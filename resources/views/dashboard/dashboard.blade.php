@extends('layouts.admin')

@section('page-title')
    {{ __('Dashboard') }}
@endsection



@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif


    @if (\Auth::user()->type == 'employee')
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Calendar') }}</h5>
                </div>
                <div class="card-body">
                    <div id='event_calendar' class='calendar'></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card" style="height: 295px;">
                <div class="card-header">
                    <h5>{{ __('Mark Attandance') }}</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted pb-0-5">
                        {{ __('My Office Time: ' . $officeTime['startTime'] . ' to ' . $officeTime['endTime']) }}</p>
                    <div class="row">
                        <div class="col-md-6 float-right border-right">
                            {{ Form::open(['url' => 'attendanceemployee/attendance', 'method' => 'post']) }}
                            @if (empty($employeeAttendance) || $employeeAttendance->clock_out != '00:00:00')
                                <button type="submit" value="0" name="in" id="clock_in"
                                    class="btn btn-primary">{{ __('CLOCK IN') }}</button>
                            @else
                                <button type="submit" value="0" name="in" id="clock_in"
                                    class="btn btn-primary disabled" disabled>{{ __('CLOCK IN') }}</button>
                            @endif
                            {{ Form::close() }}
                        </div>
                        <div class="col-md-6 float-left">
                            @if (!empty($employeeAttendance) && $employeeAttendance->clock_out == '00:00:00')
                                {{ Form::model($employeeAttendance, ['route' => ['attendanceemployee.update', $employeeAttendance->id], 'method' => 'PUT']) }}
                                <button type="submit" value="1" name="out" id="clock_out"
                                    class="btn btn-danger">{{ __('CLOCK OUT') }}</button>
                            @else
                                <button type="submit" value="1" name="out" id="clock_out"
                                    class="btn btn-danger disabled" disabled>{{ __('CLOCK OUT') }}</button>
                            @endif
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card" style="height: 462px;">
                <div class="card-header card-body table-border-style">
                    <h5>{{ __('Meeting schedule') }}</h5>
                </div>
                <div class="card-body" style="height: 320px">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Meeting title') }}</th>
                                    <th>{{ __('Meeting Date') }}</th>
                                    <th>{{ __('Meeting Time') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($meetings as $meeting)
                                    <tr>
                                        <td>{{ $meeting->title }}</td>
                                        <td>{{ \Auth::user()->dateFormat($meeting->date) }}</td>
                                        <td>{{ \Auth::user()->timeFormat($meeting->time) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5>{{ __('Announcement List') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Description') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($announcements as $announcement)
                                    <tr>
                                        <td>{{ $announcement->title }}</td>
                                        <td>{{ \Auth::user()->dateFormat($announcement->start_date) }}</td>
                                        <td>{{ \Auth::user()->dateFormat($announcement->end_date) }}</td>
                                        <td>{{ $announcement->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5>{{ __('Approved Employee List') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Leave Type') }}</th>
                                    <th>{{ __('Applied On') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Total Days') }}</th>
                                    <th>{{ __('Leave Reason') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                {{-- @dd($approvedLeave) --}}
                                @foreach ($approvedLeave as $leave)
                                    <tr>
                                        <td>{{ !empty($leave->leave->employees) ? $leave->leave->employees->name : '' }}</td>
                                        <td>{{ !empty(\Auth::user()->getLeaveType($leave->leave->leave_type_id)) ? \Auth::user()->getLeaveType($leave->leave->leave_type_id)->title : '' }}
                                        </td>
                                        <td>{{ \Auth::user()->dateFormat($leave->leave->applied_on) }}</td>
                                        <td>{{ \Auth::user()->dateFormat($leave->leave->start_date) }}</td>
                                        <td>{{ \Auth::user()->dateFormat($leave->leave->end_date) }}</td>
                                        @php
                                            $startDate = new \DateTime($leave->leave->start_date);
                                            $endDate = new \DateTime($leave->leave->end_date);
                                            $total_leave_days = !empty($startDate->diff($endDate)) ? $startDate->diff($endDate)->days : 0;
                                        @endphp
                                        <td>{{ $leave->leave->total_leave_days }}</td>
                                        <td>{{ $leave->leave->leave_reason }}</td>
                                        <td>
                                            @if ($leave->status == 'Pending')
                                                <div class="badge bg-warning p-2 px-3 rounded status-badge5">
                                                    {{ $leave->status }}</div>
                                            @elseif($leave->status == 'Approved')
                                                <div class="badge bg-success p-2 px-3 rounded status-badge5">
                                                    {{ $leave->status }}</div>
                                            @else
                                                <div class="badge bg-danger p-2 px-3 rounded status-badge5">
                                                    {{ $leave->status }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-btn bg-success ms-2">
                                                <a href="#approveModal-{{ $leave->leave->id }}"
                                                    class="mx-3 btn btn-sm  align-items-center approved-leave"
                                                    data-bs-toggle="modal" data-id="{{ $leave->leave_id }}"
                                                    data-bs-target="#approveModal-{{ $leave->leave->id }}">
                                                    <i class="ti ti-caret-right text-white"></i>
                                                </a>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="approveModal-{{ $leave->leave->id }}"
                                                tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="margin-left: 15px">
                                                            <h5 class="modal-title" id="exampleModalLabel">Modal title
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        {{ Form::open(['route' => 'approve.employee.leave', 'method' => 'post']) }}
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <table class="table">
                                                                        <tr role="row">
                                                                            <th>{{ __('Employee') }}</th>
                                                                            <td>{{ $leave->leave->employees->name }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>{{ __('Leave Type ') }}</th>
                                                                            <td>{{ !empty(\Auth::user()->getLeaveType($leave->leave->leave_type_id)) ? \Auth::user()->getLeaveType($leave->leave->leave_type_id)->title : '' }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>{{ __('Appplied On') }}</th>
                                                                            <td>{{ \Auth::user()->dateFormat($leave->leave->applied_on) }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>{{ __('Start Date') }}</th>
                                                                            <td>{{ \Auth::user()->dateFormat($leave->leave->start_date) }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>{{ __('End Date') }}</th>
                                                                            <td>{{ \Auth::user()->dateFormat($leave->leave->end_date) }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>{{ __('Leave Reason') }}</th>
                                                                            <td>{{ $leave->leave->leave_reason }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>{{ __('Status') }}</th>
                                                                            <td>
                                                                                @if ($leave->status == 'Pending')
                                                                                    <div
                                                                                        class="badge bg-warning p-2 px-3 rounded status-badge5">
                                                                                        {{ $leave->status }}</div>
                                                                                @elseif($leave->status == 'Approved')
                                                                                    <div
                                                                                        class="badge bg-success p-2 px-3 rounded status-badge5">
                                                                                        {{ $leave->status }}</div>
                                                                                @else($leave->status == "Reject")
                                                                                    <div
                                                                                        class="badge bg-danger p-2 px-3 rounded status-badge5">
                                                                                        {{ $leave->status }}</div>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>{{ __('Approved By') }}</th>
                                                                            <td>
                                                                                {{-- @foreach ($approvedLeaveAll as $item) --}}
                                                                                <div class="approved-leave-employee">
                                                                                    {{-- <div class="row mt-2">
                                                                                                <div class="col-8">
                                                                                                    {{ $item->employee->name }}
                                                                                                </div>
                                                                                                @if ($item->status == 'Pending')
                                                                                                    <div class="col-4 badge bg-warning p-2 px-3 rounded status-badge5">
                                                                                                        {{ $item->status }}</div>
                                                                                                @elseif ($item->status == 'Waiting')
                                                                                                    <div class="col-4 badge bg-info p-2 px-3 rounded status-badge5">
                                                                                                        {{ $item->status }}</div>
                                                                                                @elseif($item->status == 'Approved')
                                                                                                    <div class="col-4 badge bg-success p-2 px-3 rounded status-badge5">
                                                                                                        {{ $item->status }}</div>
                                                                                                @else($item->status == "Reject")
                                                                                                    <div class="col-4 badge bg-danger p-2 px-3 rounded status-badge5">
                                                                                                        {{ $item->status }}</div>
                                                                                                @endif
                                                                                            </div> --}}
                                                                                </div>
                                                                                {{-- @endforeach --}}
                                                                            </td>
                                                                        </tr>
                                                                        <input type="hidden" value="{{ $leave->id }}"
                                                                            name="leave_id">
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-12">
                                                        <input type="submit" class="btn-create badge-success" value="{{ __('Approval') }}" name="status">
                                                        <input type="submit" class="btn-create bg-danger" value="{{ __('Reject') }}" name="status">
                                                    </div> --}}
                                                        @if ($leave->status == 'Pending')
                                                            <div class="modal-footer">
                                                                <input type="submit" value="{{ __('Approved') }}"
                                                                    class="btn btn-success rounded" name="status">
                                                                <input type="submit" value="{{ __('Reject') }}"
                                                                    class="btn btn-danger rounded" name="status">
                                                            </div>
                                                        @endif
                                                        {{ Form::close() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-xxl-12">

            {{-- start --}}
            <div class="row">

                <div class="col-lg-4 col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-primary">
                                            <i class="ti ti-users"></i>
                                        </div>
                                        <div class="ms-3">
                                            <small class="text-muted">{{ __('Total') }}</small>
                                            <h6 class="m-0">{{ __('Staff') }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-primary">{{ $countUser + $countEmployee }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-info">
                                            <i class="ti ti-ticket"></i>
                                        </div>
                                        <div class="ms-3">
                                            <small class="text-muted">{{ __('Total') }}</small>
                                            <h6 class="m-0">{{ __('Ticket') }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-info"> {{ $countTicket }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="theme-avtar bg-warning">
                                            <i class="ti ti-wallet"></i>
                                        </div>
                                        <div class="ms-3">
                                            <small class="text-muted">{{ __('Total') }}</small>
                                            <h6 class="m-0">{{ __('Account Balance') }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-warning">{{ \Auth::user()->priceFormat($accountBalance) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-primary">
                                    <i class="ti ti-cast"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{ __('Total') }}</small>
                                    <h6 class="m-0">{{ __('Jobs') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0 text-primary">{{ $activeJob + $inActiveJOb }}</h4>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4 col-md-6">

            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-info">
                                    <i class="ti ti-cast"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{ __('Total') }}</small>
                                    <h6 class="m-0">{{ __('Active Jobs') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0 text-info"> {{ $activeJob }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">

            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-warning">
                                    <i class="ti ti-cast"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{ __('Total') }}</small>
                                    <h6 class="m-0">{{ __('Inactive Jobs') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0 text-warning">{{ $inActiveJOb }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- </div> --}}

        {{-- end --}}
        <div class="col-xxl-12">
            <div class="row">
                <div class="col-xl-5">

                    <div class="card">
                        <div class="card-header card-body table-border-style">
                            <h5>{{ __('Meeting schedule') }}</h5>
                        </div>
                        <div class="card-body" style="height: 324px; overflow:auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Time') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        @foreach ($meetings as $meeting)
                                            <tr>
                                                <td>{{ $meeting->title }}</td>
                                                <td>{{ \Auth::user()->dateFormat($meeting->date) }}</td>
                                                <td>{{ \Auth::user()->timeFormat($meeting->time) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header card-body table-border-style">
                            <h5>{{ __("Today's Not Clock In") }}</h5>
                        </div>
                        <div class="card-body" style="height: 324px; overflow:auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        @foreach ($notClockIns as $notClockIn)
                                            <tr>
                                                <td>{{ $notClockIn->name }}</td>
                                                <td><span class="absent-btn">{{ __('Absent') }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-7">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Calendar') }}</h5>
                        </div>
                        <div class="card-body card-635 ">
                            <div id='calendar' class='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5>{{ __('Announcement List') }}</h5>
                </div>
                <div class="card-body" style="height: 270px; overflow:auto">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Description') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($announcements as $announcement)
                                    <tr>
                                        <td>{{ $announcement->title }}</td>
                                        <td>{{ \Auth::user()->dateFormat($announcement->start_date) }}</td>
                                        <td>{{ \Auth::user()->dateFormat($announcement->end_date) }}</td>
                                        <td>{{ $announcement->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        </div>
    @endif
@endsection




@push('script-page')
    <script src="{{ asset('assets/js/plugins/main.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".approved-leave", function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    "url": "/get-approved-leave/" + id,
                    "method": "get",
                    success: function(data) {
                        var html = '';
                        var i;

                        for (i = 0; i < data.length; i++) {
                            html += '<div class="row mt-2"> <div class="col-8">' + data[i].employee.name + '</div>'
                            if (data[i].status == 'Pending') {
                                html += '<div class="col-4 badge bg-warning p-2 px-3 rounded status-badge5">' + data[i].status + '</div>'
                            } else if (data[i].status == 'Approved') {
                                html += '<div class="col-4 badge bg-success p-2 px-3 rounded status-badge5">' + data[i].status + '</div>'
                            } else if (data[i].status == 'Waiting') {
                                html += '<div class="col-4 badge bg-info p-2 px-3 rounded status-badge5">' + data[i].status + '</div>'
                            } else {
                                html += '<div class="col-4 badge bg-danger p-2 px-3 rounded status-badge5">' + data[i].status + '</div>'
                            } 
                            html += '</div>'
                        }
                    $('.approved-leave-employee').html(html);
                    }
                })
                console.log(id);
            });
        });
    </script>
    <script type="text/javascript">
        (function() {
            var etitle;
            var etype;
            var etypeclass;
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridDay,timeGridWeek,dayGridMonth'
                },
                buttonText: {
                    timeGridDay: "{{ __('Day') }}",
                    timeGridWeek: "{{ __('Week') }}",
                    dayGridMonth: "{{ __('Month') }}"
                },
                themeSystem: 'bootstrap',

                slotDuration: '00:10:00',
                navLinks: true,
                droppable: true,
                selectable: true,
                selectMirror: true,
                editable: true,
                dayMaxEvents: true,
                handleWindowResize: true,
                events: {!! json_encode($arrEvents) !!},


            });

            calendar.render();
        })();
    </script>

    <script>
        (function() {
            var etitle;
            var etype;
            var etypeclass;
            var calendar = new FullCalendar.Calendar(document.getElementById('event_calendar'), {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridDay,timeGridWeek,dayGridMonth'
                },
                buttonText: {
                    timeGridDay: "{{ __('Day') }}",
                    timeGridWeek: "{{ __('Week') }}",
                    dayGridMonth: "{{ __('Month') }}"
                },
                themeSystem: 'bootstrap',

                slotDuration: '00:10:00',
                navLinks: true,
                droppable: true,
                selectable: true,
                selectMirror: true,
                editable: true,
                dayMaxEvents: true,
                handleWindowResize: true,
                events: {!! json_encode($arrEvents) !!},


            });

            calendar.render();
        })();
    </script>
    {{-- <script>
        (function() {
            var etitle;
            var etype;
            var etypeclass;
            var calendar = new FullCalendar.Calendar(document.getElementById('event_calendar'), {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridDay,timeGridWeek,dayGridMonth'
                },
                buttonText: {
                    timeGridDay: "{{__('Day')}}",
                    timeGridWeek: "{{__('Week')}}",
                    dayGridMonth: "{{__('Month')}}"
                },
                themeSystem: 'bootstrap',
                slotDuration: '00:10:00',
                navLinks: true,
                droppable: true,
                selectable: true,
                selectMirror: true,
                editable: true,
                dayMaxEvents: true,
                handleWindowResize: true,
                events: {!! json_encode($arrEvents) !!},
            });
            calendar.render();
        })();


        $(document).on('click', '.fc-day-grid-event', function(e) {
            if (!$(this).hasClass('deal')) {
                e.preventDefault();
                var event = $(this);
                var title = $(this).find('.fc-content .fc-title').html();
                var size = 'md';
                var url = $(this).attr('href');
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);

                $.ajax({
                    url: url,
                    success: function(data) {
                        $('#commonModal .body').html(data);
                        $("#commonModal").modal('show');
                    },
                    error: function(data) {
                        data = data.responseJSON;
                        show_toastr('Error', data.error, 'error')
                    }
                });
            }
        });
    </script> --}}
    {{-- <script>
        // event_calendar (not working now)
        var e, t, a = $('[data-toggle="event_calendar"]');
        a.length && (t = {
            header: {right: "", center: "", left: ""},
            buttonIcons: {prev: "calendar--prev", next: "calendar--next"},
            theme: !1,
            selectable: !0,
            selectHelper: !0,
            editable: !0,
            events: {!! json_encode($arrEvents) !!} ,
            eventStartEditable: !1,
            locale: '{{basename(App::getLocale())}}',
            dayClick: function (e) {
                var t = moment(e).toISOString();
                $("#new-event").modal("show"), $(".new-event--title").val(""), $(".new-event--start").val(t), $(".new-event--end").val(t)
            },
            eventResize: function (event) {
                var eventObj = {
                    start: event.start.format(),
                    end: event.end.format(),
                };

                /*$.ajax({
                    url: event.resize_url,
                    method: 'PUT',
                    data: eventObj,
                    success: function (response) {
                    },
                    error: function (data) {
                        data = data.responseJSON;
                    }
                });*/
            },
            viewRender: function (t) {
                e.fullCalendar("getDate").month(), $(".fullcalendar-title").html(t.title)
            },
            eventClick: function (e, t) {
                var title = e.title;
                var url = e.url;

                if (typeof url != 'undefined') {
                    $("#commonModal .modal-title").html(title);
                    $("#commonModal .modal-dialog").addClass('modal-md');
                    $("#commonModal").modal('show');
                    $.get(url, {}, function (data) {
                        $('#commonModal .modal-body').html(data);
                    });
                    return false;
                }
            }
        }, (e = a).fullCalendar(t),
            $("body").on("click", "[data-calendar-view]", function (t) {
                t.preventDefault(), $("[data-calendar-view]").removeClass("active"), $(this).addClass("active");
                var a = $(this).attr("data-calendar-view");
                e.fullCalendar("changeView", a)
            }), $("body").on("click", ".fullcalendar-btn-next", function (t) {
            t.preventDefault(), e.fullCalendar("next")
        }), $("body").on("click", ".fullcalendar-btn-prev", function (t) {
            t.preventDefault(), e.fullCalendar("prev")
        }));
    </script> --}}
@endpush
