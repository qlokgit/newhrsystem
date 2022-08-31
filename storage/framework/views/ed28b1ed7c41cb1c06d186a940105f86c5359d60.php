<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
    <?php if(session('status')): ?>
        <div class="alert alert-success" role="alert">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>


    <?php if(\Auth::user()->type == 'employee'): ?>
        <div class="col-xxl-6">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Calendar')); ?></h5>
                </div>
                <div class="card-body">
                    <div id='event_calendar' class='calendar'></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card" style="height: 295px;">
                <div class="card-header">
                    <h5><?php echo e(__('Mark Attandance')); ?></h5>
                </div>
                <div class="card-body">
                    <p class="text-muted pb-0-5">
                        <?php echo e(__('My Office Time: ' . $officeTime['startTime'] . ' to ' . $officeTime['endTime'])); ?></p>
                    <div class="row">
                        <div class="col-md-6 float-right border-right">
                            <?php echo e(Form::open(['url' => 'attendanceemployee/attendance', 'method' => 'post'])); ?>

                            <?php if(empty($employeeAttendance) || $employeeAttendance->clock_out != '00:00:00'): ?>
                                <button type="submit" value="0" name="in" id="clock_in"
                                    class="btn btn-primary"><?php echo e(__('CLOCK IN')); ?></button>
                            <?php else: ?>
                                <button type="submit" value="0" name="in" id="clock_in"
                                    class="btn btn-primary disabled" disabled><?php echo e(__('CLOCK IN')); ?></button>
                            <?php endif; ?>
                            <?php echo e(Form::close()); ?>

                        </div>
                        <div class="col-md-6 float-left">
                            <?php if(!empty($employeeAttendance) && $employeeAttendance->clock_out == '00:00:00'): ?>
                                <?php echo e(Form::model($employeeAttendance, ['route' => ['attendanceemployee.update', $employeeAttendance->id], 'method' => 'PUT'])); ?>

                                <button type="submit" value="1" name="out" id="clock_out"
                                    class="btn btn-danger"><?php echo e(__('CLOCK OUT')); ?></button>
                            <?php else: ?>
                                <button type="submit" value="1" name="out" id="clock_out"
                                    class="btn btn-danger disabled" disabled><?php echo e(__('CLOCK OUT')); ?></button>
                            <?php endif; ?>
                            <?php echo e(Form::close()); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card" style="height: 462px;">
                <div class="card-header card-body table-border-style">
                    <h5><?php echo e(__('Meeting schedule')); ?></h5>
                </div>
                <div class="card-body" style="height: 320px">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Meeting title')); ?></th>
                                    <th><?php echo e(__('Meeting Date')); ?></th>
                                    <th><?php echo e(__('Meeting Time')); ?></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php $__currentLoopData = $meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($meeting->title); ?></td>
                                        <td><?php echo e(\Auth::user()->dateFormat($meeting->date)); ?></td>
                                        <td><?php echo e(\Auth::user()->timeFormat($meeting->time)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5><?php echo e(__('Announcement List')); ?></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Title')); ?></th>
                                    <th><?php echo e(__('Start Date')); ?></th>
                                    <th><?php echo e(__('End Date')); ?></th>
                                    <th><?php echo e(__('Description')); ?></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($announcement->title); ?></td>
                                        <td><?php echo e(\Auth::user()->dateFormat($announcement->start_date)); ?></td>
                                        <td><?php echo e(\Auth::user()->dateFormat($announcement->end_date)); ?></td>
                                        <td><?php echo e($announcement->description); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5><?php echo e(__('Approved Employee List')); ?></h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Leave Type')); ?></th>
                                    <th><?php echo e(__('Applied On')); ?></th>
                                    <th><?php echo e(__('Start Date')); ?></th>
                                    <th><?php echo e(__('End Date')); ?></th>
                                    <th><?php echo e(__('Total Days')); ?></th>
                                    <th><?php echo e(__('Leave Reason')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                
                                <?php $__currentLoopData = $approvedLeave; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($leave->leave->employees->name); ?></td>
                                        <td><?php echo e(!empty(\Auth::user()->getLeaveType($leave->leave->leave_type_id)) ? \Auth::user()->getLeaveType($leave->leave->leave_type_id)->title : ''); ?>

                                        </td>
                                        <td><?php echo e(\Auth::user()->dateFormat($leave->leave->applied_on)); ?></td>
                                        <td><?php echo e(\Auth::user()->dateFormat($leave->leave->start_date)); ?></td>
                                        <td><?php echo e(\Auth::user()->dateFormat($leave->leave->end_date)); ?></td>
                                        <?php
                                            $startDate = new \DateTime($leave->leave->start_date);
                                            $endDate = new \DateTime($leave->leave->end_date);
                                            $total_leave_days = !empty($startDate->diff($endDate)) ? $startDate->diff($endDate)->days : 0;
                                        ?>
                                        <td><?php echo e($leave->leave->total_leave_days); ?></td>
                                        <td><?php echo e($leave->leave->leave_reason); ?></td>
                                        <td>
                                            <?php if($leave->status == 'Pending'): ?>
                                                <div class="badge bg-warning p-2 px-3 rounded status-badge5">
                                                    <?php echo e($leave->status); ?></div>
                                            <?php elseif($leave->status == 'Approved'): ?>
                                                <div class="badge bg-success p-2 px-3 rounded status-badge5">
                                                    <?php echo e($leave->status); ?></div>
                                            <?php else: ?>
                                                <div class="badge bg-danger p-2 px-3 rounded status-badge5">
                                                    <?php echo e($leave->status); ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="action-btn bg-success ms-2">
                                                <a href="#approveModal-<?php echo e($leave->leave->id); ?>"
                                                    class="mx-3 btn btn-sm  align-items-center approved-leave"
                                                    data-bs-toggle="modal" data-id="<?php echo e($leave->leave_id); ?>"
                                                    data-bs-target="#approveModal-<?php echo e($leave->leave->id); ?>">
                                                    <i class="ti ti-caret-right text-white"></i>
                                                </a>
                                            </div>
                                            <!-- Modal -->
                                            <div class="modal fade" id="approveModal-<?php echo e($leave->leave->id); ?>"
                                                tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="margin-left: 15px">
                                                            <h5 class="modal-title" id="exampleModalLabel">Modal title
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <?php echo e(Form::open(['route' => 'approve.employee.leave', 'method' => 'post'])); ?>

                                                        <?php echo csrf_field(); ?>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <table class="table">
                                                                        <tr role="row">
                                                                            <th><?php echo e(__('Employee')); ?></th>
                                                                            <td><?php echo e($leave->leave->employees->name); ?>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th><?php echo e(__('Leave Type ')); ?></th>
                                                                            <td><?php echo e(!empty(\Auth::user()->getLeaveType($leave->leave->leave_type_id)) ? \Auth::user()->getLeaveType($leave->leave->leave_type_id)->title : ''); ?>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th><?php echo e(__('Appplied On')); ?></th>
                                                                            <td><?php echo e(\Auth::user()->dateFormat($leave->leave->applied_on)); ?>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th><?php echo e(__('Start Date')); ?></th>
                                                                            <td><?php echo e(\Auth::user()->dateFormat($leave->leave->start_date)); ?>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th><?php echo e(__('End Date')); ?></th>
                                                                            <td><?php echo e(\Auth::user()->dateFormat($leave->leave->end_date)); ?>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th><?php echo e(__('Leave Reason')); ?></th>
                                                                            <td><?php echo e($leave->leave->leave_reason); ?>

                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th><?php echo e(__('Status')); ?></th>
                                                                            <td>
                                                                                <?php if($leave->status == 'Pending'): ?>
                                                                                    <div
                                                                                        class="badge bg-warning p-2 px-3 rounded status-badge5">
                                                                                        <?php echo e($leave->status); ?></div>
                                                                                <?php elseif($leave->status == 'Approved'): ?>
                                                                                    <div
                                                                                        class="badge bg-success p-2 px-3 rounded status-badge5">
                                                                                        <?php echo e($leave->status); ?></div>
                                                                                <?php else: ?>
                                                                                    <div
                                                                                        class="badge bg-danger p-2 px-3 rounded status-badge5">
                                                                                        <?php echo e($leave->status); ?></div>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th><?php echo e(__('Approved By')); ?></th>
                                                                            <td>
                                                                                
                                                                                <div class="approved-leave-employee">
                                                                                    
                                                                                </div>
                                                                                
                                                                            </td>
                                                                        </tr>
                                                                        <input type="hidden" value="<?php echo e($leave->id); ?>"
                                                                            name="leave_id">
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <?php if($leave->status == 'Pending'): ?>
                                                            <div class="modal-footer">
                                                                <input type="submit" value="<?php echo e(__('Approved')); ?>"
                                                                    class="btn btn-success rounded" name="status">
                                                                <input type="submit" value="<?php echo e(__('Reject')); ?>"
                                                                    class="btn btn-danger rounded" name="status">
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::close()); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="col-xxl-12">

            
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
                                            <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                            <h6 class="m-0"><?php echo e(__('Staff')); ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-primary"><?php echo e($countUser + $countEmployee); ?></h4>
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
                                            <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                            <h6 class="m-0"><?php echo e(__('Ticket')); ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-info"> <?php echo e($countTicket); ?></h4>
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
                                            <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                            <h6 class="m-0"><?php echo e(__('Account Balance')); ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0 text-warning"><?php echo e(\Auth::user()->priceFormat($accountBalance)); ?></h4>
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
                                    <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                    <h6 class="m-0"><?php echo e(__('Jobs')); ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0 text-primary"><?php echo e($activeJob + $inActiveJOb); ?></h4>
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
                                    <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                    <h6 class="m-0"><?php echo e(__('Active Jobs')); ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0 text-info"> <?php echo e($activeJob); ?></h4>
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
                                    <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                    <h6 class="m-0"><?php echo e(__('Inactive Jobs')); ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h4 class="m-0 text-warning"><?php echo e($inActiveJOb); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        
        <div class="col-xxl-12">
            <div class="row">
                <div class="col-xl-5">

                    <div class="card">
                        <div class="card-header card-body table-border-style">
                            <h5><?php echo e(__('Meeting schedule')); ?></h5>
                        </div>
                        <div class="card-body" style="height: 324px; overflow:auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Title')); ?></th>
                                            <th><?php echo e(__('Date')); ?></th>
                                            <th><?php echo e(__('Time')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        <?php $__currentLoopData = $meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($meeting->title); ?></td>
                                                <td><?php echo e(\Auth::user()->dateFormat($meeting->date)); ?></td>
                                                <td><?php echo e(\Auth::user()->timeFormat($meeting->time)); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header card-body table-border-style">
                            <h5><?php echo e(__("Today's Not Clock In")); ?></h5>
                        </div>
                        <div class="card-body" style="height: 324px; overflow:auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo e(__('Name')); ?></th>
                                            <th><?php echo e(__('Status')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="list">
                                        <?php $__currentLoopData = $notClockIns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notClockIn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($notClockIn->name); ?></td>
                                                <td><span class="absent-btn"><?php echo e(__('Absent')); ?></span></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-7">
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Calendar')); ?></h5>
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
                    <h5><?php echo e(__('Announcement List')); ?></h5>
                </div>
                <div class="card-body" style="height: 270px; overflow:auto">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Title')); ?></th>
                                    <th><?php echo e(__('Start Date')); ?></th>
                                    <th><?php echo e(__('End Date')); ?></th>
                                    <th><?php echo e(__('Description')); ?></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($announcement->title); ?></td>
                                        <td><?php echo e(\Auth::user()->dateFormat($announcement->start_date)); ?></td>
                                        <td><?php echo e(\Auth::user()->dateFormat($announcement->end_date)); ?></td>
                                        <td><?php echo e($announcement->description); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>




<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/main.min.js')); ?>"></script>
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
                                html += ' class="col-4 badge bg-danger p-2 px-3 rounded status-badge5">' + data[i].status + '</div>'
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
                    timeGridDay: "<?php echo e(__('Day')); ?>",
                    timeGridWeek: "<?php echo e(__('Week')); ?>",
                    dayGridMonth: "<?php echo e(__('Month')); ?>"
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
                events: <?php echo json_encode($arrEvents); ?>,


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
                    timeGridDay: "<?php echo e(__('Day')); ?>",
                    timeGridWeek: "<?php echo e(__('Week')); ?>",
                    dayGridMonth: "<?php echo e(__('Month')); ?>"
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
                events: <?php echo json_encode($arrEvents); ?>,


            });

            calendar.render();
        })();
    </script>
    
    
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Project/External/newhrsystem/resources/views/dashboard/dashboard.blade.php ENDPATH**/ ?>