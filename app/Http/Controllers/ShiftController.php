<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\DetailShift;
use App\Models\Employee;
use App\Models\EmployeeShift;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Reader\Xls\RC4;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->month);
        if (\Auth::user()->can('Manage Employee')) {
            $data['filter'] = [
                'month' => $request->month ?? date('m'),
                'year' => $request->year ??  date('Y'),
                'department' => $request->department ?? '',
                'employee' => $request->employee ?? '',
                'employees' =>   $data['employees'] = Employee::with(['user', 'shift.detailShift.employeeShift'])->where('created_by', \Auth::user()->creatorId())->whereHas('user', function ($query) {
                    $query->where('type', 'employee');
                })->get()
            ];
            if (Auth::user()->type == 'employee') {
                $data['employees'] = Employee::where('user_id', '=', Auth::user()->id)->get();
                $data['departments'] = Department::where('created_by', \Auth::user()->creatorId())->get(['name', 'id']);
                $data['employeeShift'] = EmployeeShift::where('created_by', \Auth::user()->creatorId())->get();

            } else {
                // if ($data['filter']['department'] || $data['filter']['employee']) {
                //     $data['employees'] = Employee::with(['user', 'shift.detailShift.employeeShift'])->where([['created_by', \Auth::user()->creatorId()], ['id', $data['filter']['employee']]])->whereHas('user', function ($query) use ($data) {
                //         $query->where([['type', 'employee'], ['department_id', $data['filter']['department']]]);
                //     })->get();
                // } else {
                //     $data['employees'] = Employee::with(['user', 'shift.detailShift.employeeShift'])->where('created_by', \Auth::user()->creatorId())->whereHas('user', function ($query) {
                //         $query->where('type', 'employee');
                //     })->get();
                // }

                $employee = Employee::query();
                $department = $data['filter']['department'];
                $rEmployee = $data['filter']['employee'];

                $employee->with(['user', 'shift.detailShift.employeeShift'])->where('created_by', \Auth::user()->creatorId())->whereHas('user', function ($query) {
                    $query->where('type', 'employee');
                });

                $employee->when($rEmployee, function ($q) use ($rEmployee) {
                    $q->where('id', $rEmployee);
                });
                
                $employee->when($department, function ($q) use ($department) {
                    $q->whereHas('user', function ($query) use ($department) {
                        $query->where('department_id', $department);
                    });
                });

                $data['employees'] = $employee->get();
                $data['departments'] = Department::where('created_by', \Auth::user()->creatorId())->get(['name', 'id']);
                $data['employeeShift'] = EmployeeShift::where('created_by', \Auth::user()->creatorId())->get();
            }


            return view('shift.index', $data);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->can('Create Payment Type')) {
            $data['employees'] = User::where('created_by', \Auth::user()->creatorId())->where('type', 'employee')->get(['name', 'id']);
            $data['departments'] = Department::where('created_by', \Auth::user()->creatorId())->get(['name', 'id']);
            $data['employeeShift'] = EmployeeShift::where('created_by', \Auth::user()->creatorId())->get(['name', 'id']);
            return view('shift.create', $data);
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->employee_id);
        if (\Auth::user()->can('Create Payment Type')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'employee_id' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $employee = Employee::where('id', $request->employee_id)->first();

            $month = (int)$request->month + 1;
            $getMonth = strlen($month) > 1 ? $month : '0' . $month;

            foreach ($request->employee_id as $value) {
                $shift = Shift::where([['employee_id', $value], ['department_id', $employee->department_id], ['assign_shift_by', 'date']])->first();
                if (!$shift) {
                    $shift = Shift::create([
                        'department_id' => $request->department_id,
                        'employee_id' => $value,
                        'assign_shift_by' => $request->assign_shift_by,
                        'month' => $request->assign_shift_by == 'month' ? $getMonth . '-' . $request->year : null,
                        'created_by' => \Auth::user()->creatorId()
                    ]);
                }

                $detailShift = DetailShift::where([['shift_id', $shift->id], ['employee_shift_id', $request->employee_shift_id], ['date', $request->dates]])->first();
                if ($shift) {
                    if ($shift->assign_shift_by == 'month') {
                        if ($shift->assign_shift_by == 'month') {
                            $currentMonth = date('m');
                            $currentGetMonth = strlen($currentMonth) > 1 ? $currentMonth : '0' . $currentMonth;
                            $forDate = $shift->month == $currentGetMonth . '-' . date('Y') ? date('d') : 1;
                            for ($d = $forDate; $d <= 31; $d++) {
                                $time = mktime(12, 0, 0, $month, $d, $request->year);
                                if (date('m', $time) == $month) {
                                    DetailShift::create([
                                        'shift_id' => $shift->id,
                                        'employee_shift_id' => $request->employee_shift_id,
                                        'date' => date('Y-m-d', $time),
                                    ]);
                                }
                            }
                        }
                    } else {
                        if (!$detailShift) {
                            DetailShift::create([
                                'shift_id' => $shift->id,
                                'employee_shift_id' => $request->employee_shift_id,
                                'date' => $request->dates,
                            ]);
                        } else {
                            return redirect()->route('shift.index')->with('error', __('Shift Roster already create.'));
                        }
                    }
                }

                if ($request->send_email == 'send-email') {
                    $output = [
                        'detailShift' => DetailShift::where('shift_id', $shift->id)->orderBy('date', 'ASC')->get()
                    ];

                    Mail::to($employee->email)->send(new \App\Mail\ShiftEmail(($output)));
                }
            }

            return redirect()->route('shift.index')->with('success', __('Shift Roster successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function edit(Shift $shift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shift $shift)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift $shift)
    {
        //
    }

    public function getEmployeeByDepartment($id)
    {
        try {
            $employee = Employee::where('department_id', $id)->whereHas('user', function ($query) {
                $query->where('created_by', \Auth::user()->creatorId());
            })->get();

            return response()->json([
                'status' => 'success',
                'data' => $employee
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'data' => $th
            ]);
        }
    }

    public function setEmployeeByDate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'employee_shift_id' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $employee = Employee::where('id', $request->employee_id)->first();
        $shift = Shift::where([['employee_id', $request->employee_id], ['department_id', $employee->department_id], ['assign_shift_by', 'date']])->first();
        if (!$shift) {
            $shift = Shift::create([
                'department_id' => $employee->department_id,
                'employee_id' => $request->employee_id,
                'assign_shift_by' => 'date',
                'created_by' => \Auth::user()->creatorId()
            ]);
        }

        $detailShift = DetailShift::where([['shift_id', $shift->id], ['employee_shift_id', $request->employee_shift_id], ['date', $request->select_year]])->first();
        // dd($detailShift);

        if (!$detailShift) {
            DetailShift::create([
                'shift_id' => $shift->id,
                'employee_shift_id' => $request->employee_shift_id,
                'date' => $request->select_year
            ]);
        } else {
            return redirect()->route('shift.index')->with('error', __('Shift Roster already create.'));
        }

        return redirect()->route('shift.index')->with('success', __('Shift Roster successfully created.'));
    }

    public function deleteShiftRoaster($id)
    {
        $data = DetailShift::find($id);
        if ($data) {
            $data->delete();
            return redirect()->route('shift.index')->with('success', __('Shift Roster success delete.'));
        } else {
            return redirect()->route('shift.index')->with('error', __('Shift Roster not found.'));
        }
    }

    public function editShiftRoaster(Request $request)
    {
        $data = DetailShift::find($request->shift_id);
        if ($data) {
            $data->employee_shift_id = $request->employee_shift_id;
            $data->save();
            return redirect()->route('shift.index')->with('success', __('Shift Roster success edit.'));
        } else {
            return redirect()->route('shift.index')->with('error', __('Shift Roster not found.'));
        }
    }
}
