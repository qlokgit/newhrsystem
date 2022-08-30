<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Leave;
use App\Models\Utility;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Exports\LeaveExport;
use Illuminate\Http\Request;
use App\Mail\LeaveActionSend;

use Illuminate\Support\Carbon;
use App\Imports\EmployeesImport;
use App\Models\ApprovedLeave;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class LeaveController extends Controller
{
    public function index()
    {

        if (\Auth::user()->can('Manage Leave')) {
            $leaves = Leave::where('created_by', '=', \Auth::user()->creatorId())->get();
            if (\Auth::user()->type == 'employee') {
                $user     = \Auth::user();
                $employee = Employee::where('user_id', '=', $user->id)->first();
                $leaves   = Leave::with('approvedLeave')->where('employee_id', '=', $employee->id)->get();
            } else {
                $leaves = Leave::with('approvedLeave')->where('created_by', '=', \Auth::user()->creatorId())->get();
            }

            return view('leave.index', compact('leaves'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('Create Leave')) {
            if (Auth::user()->type == 'employee') {
                $employees = Employee::where('user_id', '=', \Auth::user()->id)->get()->pluck('name', 'id');
            } else {
                $employees = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            }
            $leavetypes      = LeaveType::where('created_by', '=', \Auth::user()->creatorId())->get();
            $leavetypes_days = LeaveType::where('created_by', '=', \Auth::user()->creatorId())->get();

            //            dd(Employee::employeeTotalLeave(1));
            return view('leave.create', compact('employees', 'leavetypes', 'leavetypes_days'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        $id_leave = (int) current(explode(',', $request->leave_type_id));

        $check_leave = LeaveType::find($request->leave_type_id);

        $from_date = Carbon::parse($request->start_date);
        $to_date = Carbon::parse($request->end_date);
        $answer_in_days = $to_date->diffInDays($from_date);
        $total_leave = $answer_in_days + 1;

        $num = (int) last(explode(',', $request->leave_type_id));


        if ($total_leave > $num) {
            return redirect('/leave')->with('error', __('Tanggal yang di input Melebihi Batas Cuti yang di tentukan'));
        }

        $now = Carbon::now();
        // echo $now->year;
        // echo $now->month;
        // echo $now->weekOfYear;

        if (Auth::user()->type == 'employee') {

            $data_user = User::find(Auth::user()->id);
            $total_leave_this_year = Leave::where('employee_id', $data_user->employee->id)
                ->where('leave_type_id', $id_leave)
                ->whereYear('start_date', $now->year)
                ->sum('total_leave_days');
        } else {
            // $data_user = User::find($request->employee_id);
            $total_leave_this_year = Leave::where('employee_id', $request->employee_id)
                ->where('leave_type_id', $id_leave)
                ->whereYear('start_date', $now->year)
                ->sum('total_leave_days');
        }

        $check_all_leave = $total_leave + $total_leave_this_year;
        $remaining_leave = $num - $total_leave_this_year;
        if ($check_all_leave > $num) {
            return redirect('/leave')->with('error', 'Tahun ini kamu sudah ambil, ' . $total_leave_this_year . ' kali cuti tersisa,  ' . $remaining_leave . ' kali');
        }


        if (\Auth::user()->can('Create Leave')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'leave_type_id' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required',
                    'leave_reason' => 'required',
                    'remark' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect('/leave')->with('error', $messages->first());
            }


            $employee = Employee::where('user_id', '=', Auth::user()->id)->first();

            $leave    = new Leave();
            if (\Auth::user()->type == "employee") {
                $leave->employee_id = $employee->id;
            } else {
                $leave->employee_id = $request->employee_id;
            }

            $leave->leave_type_id    = $request->leave_type_id;
            $leave->applied_on       = date('Y-m-d');
            $leave->start_date       = $request->start_date;
            $leave->end_date         = $request->end_date;
            $leave->total_leave_days = $total_leave;
            $leave->leave_reason     = $request->leave_reason;
            $leave->remark           = $request->remark;
            $leave->status           = 'Pending';
            $leave->created_by       = \Auth::user()->creatorId();
            $leave->save();

            $approvedEmployee = $request->approved_employee_id;
            foreach ($approvedEmployee as $item) {
                // $employeeApprove = Employee::find($item);
                ApprovedLeave::create([
                    'leave_id' => $leave->id,
                    'employee_id' => $item,
                    'status' => 'Waiting'
                ]);

                // $output = [
                //     'employee' => $employeeApprove,
                //     'leave' => $leave->with('employees')->first()
                // ];

                // Mail::to($employeeApprove->email)->send(new \App\Mail\ApprovedLeave(($output)));
            }

            return redirect('/leave')->with('success', __('Leave  successfully created.'));
        } else {
            return redirect('/leave')->with('error', __('Permission denied.'));
        }
    }

    public function show(Leave $leave)
    {
        return redirect()->route('leave.index');
    }

    public function edit(Leave $leave)
    {
        if (\Auth::user()->can('Edit Leave')) {
            if ($leave->created_by == \Auth::user()->creatorId()) {
                $employees  = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $leavetypes = LeaveType::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('title', 'id');
                $approvedLeave = ApprovedLeave::with('employee')->where('leave_id', $leave->id)->get();

                return view('leave.edit', compact('leave', 'employees', 'leavetypes', 'approvedLeave'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, $leave)
    {
        $id_leave = (int) current(explode(',', $request->leave_type_id));

        $check_leave = LeaveType::find($request->leave_type_id);

        $from_date = Carbon::parse($request->start_date);
        $to_date = Carbon::parse($request->end_date);
        $answer_in_days = $to_date->diffInDays($from_date);
        $total_leave = $answer_in_days + 1;

        $num = (int) last(explode(',', $request->leave_type_id));

        if ($total_leave > $num) {
            return redirect()->back()->with('error', __('Tanggal yang di input Melebihi Batas Cuti yang di tentukan'));
        }

        $now = Carbon::now();
        // echo $now->year;
        // echo $now->month;
        // echo $now->weekOfYear;

        if (Auth::user()->type == 'employee') {

            $data_user = User::find(Auth::user()->id);
            $total_leave_this_year = Leave::where('employee_id', $data_user->employee->id)
                ->where('leave_type_id', $id_leave)
                ->whereYear('start_date', $now->year)
                ->sum('total_leave_days');
        } else {
            // $data_user = User::find($request->employee_id);
            $total_leave_this_year = Leave::where('employee_id', $request->employee_id)
                ->where('leave_type_id', $id_leave)
                ->whereYear('start_date', $now->year)
                ->sum('total_leave_days');
        }

        $check_all_leave = $total_leave + $total_leave_this_year;
        $remaining_leave = $num - $total_leave_this_year;
        if ($check_all_leave > $num) {
            return redirect()->back()->with('error', 'Tahun ini kamu sudah ambil, ' . $total_leave_this_year . ' kali cuti tersisa,  ' . $remaining_leave . ' kali');
        }

        $leave = Leave::find($leave);
        if (\Auth::user()->can('Edit Leave')) {
            if ($leave->created_by == Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'leave_type_id' => 'required',
                        'start_date' => 'required',
                        'end_date' => 'required',
                        'leave_reason' => 'required',
                        'remark' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $leave->employee_id      = $request->employee_id;
                $leave->leave_type_id    = $request->leave_type_id;
                $leave->start_date       = $request->start_date;
                $leave->end_date         = $request->end_date;
                $leave->total_leave_days = $total_leave;
                $leave->leave_reason     = $request->leave_reason;
                $leave->remark           = $request->remark;

                $leave->save();

                // if ($leave) {
                //     // dd($request->old_approved_employee_id);
                //     // foreach ($request->old_approved_employee_id as $value) {
                //     //     $approveLeave = ApprovedLeave::where(['leave_id' => $leave->id, 'employee_id' => $value])->first();
                //         foreach ($request->approved_employee_id  as $id) {
                //             $checkApprove = ApprovedLeave::where(['leave_id' => $leave->id, 'employee_id' => $id])->first();
                //             // dd($request->approved_employee_id );
                //             if ($checkApprove) {
                //                 $checkApprove->employee_id = $id;
                //                 $checkApprove->save();
                //             } 
                //         // }
                //     }
                // }

                return redirect()->route('leave.index')->with('success', __('Leave successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Leave $leave)
    {
        if (\Auth::user()->can('Delete Leave')) {
            if ($leave->created_by == \Auth::user()->creatorId()) {
                $leave->delete();

                return redirect()->route('leave.index')->with('success', __('Leave successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function export()
    {
        $name = 'leave_' . date('Y-m-d i:h:s');
        $data = Excel::download(new LeaveExport(), $name . '.xlsx');

        return $data;
    }



    public function action($id)
    {
        $leave     = Leave::find($id);
        $employee  = Employee::find($leave->employee_id);
        $leavetype = LeaveType::find($leave->leave_type_id);
        $approvedLeave = ApprovedLeave::with('employee')->where('leave_id', $leave->id)->get();

        return view('leave.action', compact('employee', 'leavetype', 'leave', 'approvedLeave'));
    }

    public function changeaction(Request $request)
    {
        $leave = Leave::find($request->leave_id);
        $emp = Employee::find($leave->employee_id);
        // dd( $leave->leave_reason);

        $leave->status = $request->status;
        if ($leave->status == 'Approval') {
            $startDate               = new \DateTime($leave->start_date);
            $endDate                 = new \DateTime($leave->end_date);
            $total_leave_days        = $startDate->diff($endDate)->days;
            $leave->total_leave_days = $total_leave_days;
            $leave->status           = 'Approve';
        }

        $leave->save();

        $getApprovedLeave = ApprovedLeave::where(['leave_id' => $leave->id, 'status' => 'Waiting'])->orderBy('id', 'asc')->first();
        $getApprovedLeave->status = 'Pending';
        $getApprovedLeave->save();

        $output = [
            'employee' => $getApprovedLeave->employee,
            'leave' => $leave->with('employees')->first()
        ];

        Mail::to($getApprovedLeave->employee->email)->send(new \App\Mail\ApprovedLeave(($output)));


        if ($request->status == 'Reject') {
            $leaveAll = ApprovedLeave::with('leave')->where('leave_id', $leave->id)->get();
            $leave->rejected_by = $emp->id;
            $leave->save();
            foreach ($leaveAll as $value) {
                $value->status = $request->status;
                $value->save();
            }
        }


        // twilio
        $setting = Utility::settings(\Auth::user()->creatorId());
        if (isset($setting['twilio_leave_approve_notification']) && $setting['twilio_leave_approve_notification'] == 1) {
            $msg = __("Your leave has been") . ' ' . $leave->status . '.';


            Utility::send_twilio_msg($emp->phone, $msg);
        }

        $setings = Utility::settings();

        if ($setings['leave_status'] == 1) {
            $employee     = Employee::where('id', $leave->employee_id)->where('created_by', '=', \Auth::user()->creatorId())->first();

            $uArr = [
                'leave_email' => $employee->email,
                'leave_status_name' => $employee->name,
                'leave_status' => $request->status,
                'leave_reason' => $leave->leave_reason,
                'leave_start_date' => $leave->start_date,
                'leave_end_date' => $leave->end_date,
                'total_leave_days' => $leave->total_leave_days,


            ];
            //  dd( $uArr);
            $resp = Utility::sendEmailTemplate('leave_status', [$employee->email], $uArr);
            return redirect()->route('leave.index')->with('success', __('Leave status successfully updated.') . ((!empty($resp) && $resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
        }

        return redirect()->route('leave.index')->with('success', __('Leave status successfully updated.'));
    }

    public function jsoncount(Request $request)
    {
        //        $leave_counts = LeaveType::select(\DB::raw('COALESCE(SUM(leaves.total_leave_days),0) AS total_leave, leave_types.title, leave_types.days,leave_types.id'))->leftjoin(
        //            'leaves', function ($join) use ($request){
        //            $join->on('leaves.leave_type_id', '=', 'leave_types.id');
        //            $join->where('leaves.employee_id', '=', $request->employee_id);
        //        }
        //        )->groupBy('leaves.leave_type_id')->get();

        $leave_counts = LeaveType::select(\DB::raw('COALESCE(SUM(leaves.total_leave_days),0) AS total_leave, leave_types.title, leave_types.days,leave_types.id'))
            ->leftjoin(
                'leaves',
                function ($join) use ($request) {
                    $join->on('leaves.leave_type_id', '=', 'leave_types.id');
                    $join->where('leaves.employee_id', '=', $request->employee_id);
                }
            )->groupBy('leaves.leave_type_id')->get();

        return $leave_counts;
    }
}
