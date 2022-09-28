<?php

namespace App\Http\Controllers;

use App\Models\EmployeeShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()) {
            $employeeShift = EmployeeShift::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('employee_shift.index', compact('employeeShift'));
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
        if (\Auth::user()) {
            return view('employee_shift.create');
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
        if (\Auth::user()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'color' => 'required',
                    'initial' => 'required',
                    'time_start' => 'required',
                    'time_end' => 'required',
                ]
            );
            

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            EmployeeShift::create([
                'name' => $request->name,
                'color' => $request->color,
                'initial' => $request->initial,
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
                'created_by' => \Auth::user()->creatorId()
            ]);

            return redirect()->route('employee_shift.index')->with('success', __('Employee Shift  successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeShift $employeeShift)
    {
        if (\Auth::user()) {
            if ($employeeShift->created_by == \Auth::user()->creatorId()) {

                return view('employee_shift.edit', compact('employeeShift'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeShift $employeeShift)
    {
        if (\Auth::user()) {
            if ($employeeShift->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',

                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $employeeShift->name = $request->name;
                $employeeShift->icon = $request->icon;
                $employeeShift->save();

                return redirect()->route('employee_shift.index')->with('success', __('Emplolyee Shift successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeShift $employeeShift)
    {
        if(\Auth::user())
        {
            if($employeeShift->created_by == \Auth::user()->creatorId())
            {
                $employeeShift->delete();

                return redirect()->route('employee_shift.index')->with('success', __('Employee Shift successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
