<?php

namespace App\Http\Controllers;

use App\Models\AccountList;
use App\Models\Announcement;
use App\Models\ApprovedLeave;
use App\Models\AttendanceEmployee;
use App\Models\Employee;
use App\Models\Event;
use App\Models\LandingPageSection;
use App\Models\Meeting;
use App\Models\Job;
use App\Models\Leave;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Payees;
use App\Models\Payer;
use App\Models\Plan;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->type == 'employee') {
                $emp = Employee::where('user_id', '=', $user->id)->first();
                $announcements = Announcement::orderBy('announcements.id', 'desc')->take(5)->leftjoin('announcement_employees', 'announcements.id', '=', 'announcement_employees.announcement_id')->where('announcement_employees.employee_id', '=', $emp->id)->orWhere(
                    function ($q) {
                        $q->where('announcements.department_id', 0)->where('announcements.employee_id', 0);
                    }
                )->get();

                $employees = Employee::get();
                $meetings  = Meeting::orderBy('meetings.id', 'desc')->take(5)->leftjoin('meeting_employees', 'meetings.id', '=', 'meeting_employees.meeting_id')->where('meeting_employees.employee_id', '=', $emp->id)->orWhere(
                    function ($q) {
                        $q->where('meetings.department_id', 0)->where('meetings.employee_id', 0);
                    }
                )->get();
                $events    = Event::select('events.*', 'events.id as event_id', 'event_employees.*')->leftjoin('event_employees', 'events.id', '=', 'event_employees.event_id')->where('event_employees.employee_id', '=', $emp->id)->orWhere(
                    function ($q) {
                        $q->where('events.department_id', 0)->where('events.employee_id', 0);
                    }
                )->get();
                //  dd($events);
                $arrEvents = [];

                foreach ($events as $event) {

                    $arr['id']              = $event['event_id'];
                    $arr['title']           = $event['title'];
                    $arr['start']           = $event['start_date'];
                    $arr['end']             = $event['end_date'];
                    $arr['className']       = $event['color'];
                    // $arr['borderColor']     = "#fff";
                    $arr['url']             = (!empty($event['event_id'])) ? route('eventsshow', $event['event_id']) : '0';
                    //  $arr['url']                = (!empty($event['event_id'])) ? route('eventsshow', $event['event_id']) : '0';

                    // $arr['textColor']       = "white";
                    $arrEvents[]            = $arr;
                }

                $date               = date("Y-m-d");
                $time               = date("H:i:s");
                $employeeAttendance = AttendanceEmployee::orderBy('id', 'desc')->where('employee_id', '=', !empty(\Auth::user()->employee) ? \Auth::user()->employee->id : 0)->where('date', '=', $date)->first();

                $officeTime['startTime'] = Utility::getValByName('company_start_time');
                $officeTime['endTime']   = Utility::getValByName('company_end_time');

                $approvedLeave = ApprovedLeave::with('leave.employees')->where('employee_id', $emp->id)->where('status', '!=', 'Waiting')->get();
                if (count($approvedLeave) != 0) {
                    $approvedLeaveAll = ApprovedLeave::with('employee')->where('leave_id', $approvedLeave[0]->leave_id)->get();
                } else {
                    $approvedLeaveAll = [];
                }

                return view('dashboard.dashboard', compact('arrEvents', 'announcements', 'employees', 'meetings', 'employeeAttendance', 'officeTime', 'approvedLeave', 'approvedLeaveAll'));
            } else if ($user->type == 'super admin') {
                $user                       = \Auth::user();
                $user['total_user']         = $user->countCompany();
                $user['total_paid_user']    = $user->countPaidCompany();
                $user['total_orders']       = Order::total_orders();
                $user['total_orders_price'] = Order::total_orders_price();
                $user['total_plan']         = Plan::total_plan();
                $user['most_purchese_plan'] = (!empty(Plan::most_purchese_plan()) ? Plan::most_purchese_plan()->name : '');

                $chartData = $this->getOrderChart(['duration' => 'week']);

                return view('dashboard.super_admin', compact('user', 'chartData'));
            } else {

                $events    = Event::where('created_by', '=', \Auth::user()->creatorId())->get();
                $arrEvents = [];

                foreach ($events as $event) {
                    $arr['id']    = $event['id'];
                    $arr['title'] = $event['title'];
                    $arr['start'] = $event['start_date'];
                    $arr['end']   = $event['end_date'];

                    $arr['className'] = $event['color'];

                    // $arr['borderColor']     = "#fff";
                    // $arr['textColor']       = "white";
                    $arr['url']             = route('event.edit', $event['id']);

                    $arrEvents[] = $arr;
                }


                $announcements = Announcement::orderBy('announcements.id', 'desc')->take(5)->where('created_by', '=', \Auth::user()->creatorId())->get();


                $emp           = User::where('type', '=', 'employee')->where('created_by', '=', \Auth::user()->creatorId())->get();
                $countEmployee = count($emp);

                $user      = User::where('type', '!=', 'employee')->where('created_by', '=', \Auth::user()->creatorId())->get();
                $countUser = count($user);

                $countTicket      = Ticket::where('created_by', '=', \Auth::user()->creatorId())->count();
                $countOpenTicket  = Ticket::where('status', '=', 'open')->where('created_by', '=', \Auth::user()->creatorId())->count();
                $countCloseTicket = Ticket::where('status', '=', 'close')->where('created_by', '=', \Auth::user()->creatorId())->count();
                //   dd($countCloseTicket);

                $currentDate = date('Y-m-d');

                $employees     = User::where('type', '=', 'employee')->where('created_by', '=', \Auth::user()->creatorId())->get();
                $countEmployee = count($employees);
                $notClockIn    = AttendanceEmployee::where('date', '=', $currentDate)->get()->pluck('employee_id');

                $notClockIns = Employee::where('created_by', '=', \Auth::user()->creatorId())->whereNotIn('id', $notClockIn)->get();

                $accountBalance = AccountList::where('created_by', '=', \Auth::user()->creatorId())->sum('initial_balance');
                $activeJob   = Job::where('status', 'active')->where('created_by', '=', \Auth::user()->creatorId())->count();
                $inActiveJOb = Job::where('status', 'in_active')->where('created_by', '=', \Auth::user()->creatorId())->count();

                $totalPayee = Payees::where('created_by', '=', \Auth::user()->creatorId())->count();
                $totalPayer = Payer::where('created_by', '=', \Auth::user()->creatorId())->count();

                $meetings = Meeting::where('created_by', '=', \Auth::user()->creatorId())->limit(8)->get();

                return view('dashboard.dashboard', compact('arrEvents', 'announcements', 'employees', 'activeJob', 'inActiveJOb', 'meetings', 'countEmployee', 'countUser', 'countTicket', 'countOpenTicket', 'countCloseTicket', 'notClockIns', 'countEmployee', 'accountBalance', 'totalPayee', 'totalPayer'));
            }
        } else {
            if (!file_exists(storage_path() . "/installed")) {
                header('location:install');
                die;
            } else {
                $settings = Utility::settings();
                if ($settings['display_landing_page'] == 'on') {
                    $plans = Plan::get();
                    $get_section = LandingPageSection::orderBy('section_order', 'ASC')->get();

                    return view('layouts.landing', compact('plans', 'get_section'));
                } else {
                    return redirect('login');
                }
            }
        }
    }

    public function getOrderChart($arrParam)
    {
        $arrDuration = [];
        if ($arrParam['duration']) {
            if ($arrParam['duration'] == 'week') {
                $previous_week = strtotime("-2 week +1 day");
                for ($i = 0; $i < 14; $i++) {
                    $arrDuration[date('Y-m-d', $previous_week)] = date('d-M', $previous_week);
                    $previous_week                              = strtotime(date('Y-m-d', $previous_week) . " +1 day");
                }
            }
        }

        $arrTask          = [];
        $arrTask['label'] = [];
        $arrTask['data']  = [];
        foreach ($arrDuration as $date => $label) {

            $data               = Order::select(\DB::raw('count(*) as total'))->whereDate('created_at', '=', $date)->first();
            $arrTask['label'][] = $label;
            $arrTask['data'][]  = $data->total;
        }

        return $arrTask;
    }

    public function approveLeave(Request $request)
    {
        $leave = ApprovedLeave::where('id', $request->leave_id)->first();
        $emp = Employee::find($leave->employee_id);
        $leaves = Leave::find($request->leaves_id);
        if ($request->status == 'Reject') {
            $leaveAll = ApprovedLeave::with('leave')->where('leave_id', $leave->leave_id)->get();
            $leaves->status = $request->status;
            $leaves->save();

            foreach ($leaveAll as $value) {
                $value->status = $request->status;
                $value->save();

                $value->leave->status = $request->status;
                $value->leave->rejected_by = $emp->id;
                $value->leave->save();
            }
        }

        $leave->update([
            'status' => $request->status
        ]);

        // dd($leaves);

        $getApprovedLeave = ApprovedLeave::with('employee')->where(['leave_id' => $leave->leave_id, 'status' => 'Waiting'])->orderBy('id', 'asc')->first();
        if ($getApprovedLeave) {
            $getApprovedLeave->status = 'Pending';
            $getApprovedLeave->save();

            $output = [
                'employee' => $getApprovedLeave->employee,
                'leave' => $emp->name,
                'type' => 'employee'
            ];

            Mail::to($getApprovedLeave->employee->email)->send(new \App\Mail\ApprovedLeave(($output)));
        } else {
            if ($leaves->status != 'Reject') {
                Leave::with('approvedLeave.employee')->where('id', $leave->leave_id)->update(['status' => 'Approved']);
            }
        }

        return redirect('/leave')->with('success', __('Approved Leave successfully.'));
    }

    public function getApprovedLeave($id)
    {
        $approvedLeave = ApprovedLeave::with('employee')->where('leave_id', $id)->get();

        return response()->json($approvedLeave);
    }

    public function readNotification($id)
    {
        try {
            $notification = Notification::where('id', $id)->first();
            $notification->is_read = true;
            $notification->save();

            return Redirect::to($notification->url);
        } catch (\Throwable $th) {
            
        }
    }
}