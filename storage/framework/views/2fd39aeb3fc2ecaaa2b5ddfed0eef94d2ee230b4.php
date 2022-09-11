

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Holiday')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Holidays List')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <!-- <a class="btn btn-sm btn-primary collapsed" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
        aria-expanded="false" aria-controls="multiCollapseExample1" data-bs-toggle="tooltip" title="<?php echo e(__('Filter')); ?>">
        <i class="ti ti-filter"></i>
    </a> -->

    <a href="<?php echo e(route('holiday.index')); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
        data-bs-original-title="<?php echo e(__('List View')); ?>">
        <i class="ti ti-list-check"></i>
    </a>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Holiday')): ?>
        <a href="#" data-url="<?php echo e(route('holiday.create')); ?>" data-ajax-popup="true"
            data-title="<?php echo e(__('Create New Holiday')); ?>" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-sm-12 col-lg-12 col-xl-12 col-md-12">
        <!-- <div class="multi-collapse mt-2 collapse" id="multiCollapseExample1" style=""> -->
            <div class="card">
                <div class="card-body">
                    <?php echo e(Form::open(['route' => ['holiday.calender'], 'method' => 'get', 'id' => 'holiday_filter'])); ?>

                    <div class="d-flex align-items-center justify-content-end">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">

                                <?php echo e(Form::label('start_date', __('Start Date'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::date('start_date', isset($_GET['start_date']) ? $_GET['start_date'] : '', ['class' => 'month-btn form-control  ', 'autocomplete' => 'off'])); ?>


                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mx-2">
                            <div class="btn-box">

                                <?php echo e(Form::label('end_date', __('End Date'), ['class' => 'form-label'])); ?>

                                <?php echo e(Form::date('end_date', isset($_GET['end_date']) ? $_GET['end_date'] : '', ['class' => 'month-btn form-control ', 'autocomplete' => 'off'])); ?>


                            </div>
                        </div>

                        <div class="col-auto float-end ms-2 mt-4">
                            <a href="#" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('holiday_filter').submit(); return false;"
                                data-bs-toggle="tooltip" title="" data-bs-original-title="apply">
                                <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                            </a>
                            <a href="<?php echo e(route('holiday.calender')); ?>" class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                title="" data-bs-original-title="Reset">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                            </a>
                        </div>

                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Calendar')); ?></h5>
                </div>
                <div class="card-body">
                    <div id='calendar' class='calendar'></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
    
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4"><?php echo e(__('Holiday List')); ?></h4>
                    <ul class="event-cards list-group list-group-flush mt-3 w-100">
                        <?php $__currentLoopData = $current_month_event; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item card mb-3">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mb-3 mb-sm-0">
                                        <div class="d-flex align-items-center">
                                            <div class="theme-avtar bg-primary">
                                                <i class="ti ti-calendar-event"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="card-text small text-primary"><?php echo e($event->occasion); ?></h6>
                                                <div class="card-text small text-dark">Start Date : <?php echo e(date('d F Y', strtotime($event->start_date))); ?>

                                                </div>
                                                <div class="card-text small text-dark">End Date : <?php echo e(date('d F Y', strtotime($event->end_date))); ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
                    </ul> 
                </div>
            </div>
        </div>
</div>
    
<?php $__env->stopSection(); ?>







<?php $__env->startPush('script-page'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/main.min.js')); ?>"></script>



    <script type="text/javascript">
        (function() {
            var etitle;
            var etype;
            var etypeclass;
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
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
                events: <?php echo $arrHolidays; ?>,


            });

            calendar.render();
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\holiday\calender.blade.php ENDPATH**/ ?>