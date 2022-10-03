<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Leave')); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Leave ')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <a href="<?php echo e(route('leave.export')); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
        data-bs-original-title="<?php echo e(__('Export')); ?>">
        <i class="ti ti-file-export"></i>
    </a>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Create Leave')): ?>
        <a href="#" id="create_leave" data-url="<?php echo e(route('leave.create')); ?>" data-ajax-popup="true"
            data-title="<?php echo e(__('Create New Leave')); ?>" data-size="lg" data-bs-toggle="tooltip" title=""
            class="btn btn-sm btn-primary" data-bs-original-title="<?php echo e(__('Create')); ?>">
            <i class="ti ti-plus"></i>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(\Auth::user()->type == 'employee'): ?>
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
                                        <td><?php echo e(!empty($leave->leave->employees) ? $leave->leave->employees->name : ''); ?>

                                        </td>
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
                                                                        <input type="hidden" value="<?php echo e($leave->leave_id); ?>"
                                                                            name="leaves_id">
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
    <?php endif; ?>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <?php if(\Auth::user()->type != 'employee'): ?>
                                    <th><?php echo e(__('Employee')); ?></th>
                                <?php endif; ?>
                                <th><?php echo e(__('Leave Type')); ?></th>
                                <th><?php echo e(__('Applied On')); ?></th>
                                <th><?php echo e(__('Start Date')); ?></th>
                                <th><?php echo e(__('End Date')); ?></th>
                                <th><?php echo e(__('Total Days')); ?></th>
                                <th><?php echo e(__('Leave Reason')); ?></th>
                                <th><?php echo e(__('status')); ?></th>
                                <th width="200px"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php if(\Auth::user()->type != 'employee'): ?>
                                        <td><?php echo e(!empty(\Auth::user()->getEmployee($leave->employee_id)) ? \Auth::user()->getEmployee($leave->employee_id)->name : ''); ?>

                                        </td>
                                    <?php endif; ?>
                                    <td><?php echo e(!empty(\Auth::user()->getLeaveType($leave->leave_type_id)) ? \Auth::user()->getLeaveType($leave->leave_type_id)->title : ''); ?>

                                    </td>
                                    <td><?php echo e(\Auth::user()->dateFormat($leave->applied_on)); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($leave->start_date)); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($leave->end_date)); ?></td>
                                    <?php
                                        $startDate = new \DateTime($leave->start_date);
                                        $endDate = new \DateTime($leave->end_date);
                                        $total_leave_days = !empty($startDate->diff($endDate)) ? $startDate->diff($endDate)->days : 0;
                                    ?>
                                    <td><?php echo e($leave->total_leave_days); ?></td>
                                    <td><?php echo e($leave->leave_reason); ?></td>
                                    <td>
                                        <?php if($leave->status == 'Pending'): ?>
                                            <div class="badge bg-warning p-2 px-3 rounded status-badge5">
                                                <?php echo e($leave->status); ?></div>
                                        <?php elseif($leave->status == 'Approved'): ?>
                                            <?php
                                                $status = array_column($leave->approvedLeave->toArray(), 'status');
                                                $checkStatus = count(array_unique($status)) === 1 && end($status) === 'Approved';
                                            ?>
                                            <?php if($checkStatus): ?>
                                                <div class="badge bg-success p-2 px-3 rounded status-badge5">
                                                    Approved</div>
                                            <?php else: ?>
                                                <div class="badge bg-warning p-2 px-3 rounded status-badge5">
                                                    Pending</div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <div class="badge bg-danger p-2 px-3 rounded status-badge5">
                                                <?php echo e($leave->status); ?></div>
                                        <?php endif; ?>
                                    </td>

                                    <td class="Action">
                                        <span>
                                            <?php if(\Auth::user()): ?>
                                            
                                                <div class="action-btn bg-success ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                        data-size="lg"
                                                        data-url="<?php echo e(URL::to('leave/' . $leave->id . '/action')); ?>"
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                        title="" data-title="<?php echo e(__('Leave Action')); ?>"
                                                        data-bs-original-title="<?php echo e(__('Manage Leave')); ?>">
                                                        <i class="ti ti-caret-right text-white"></i>
                                                    </a>
                                                </div>
                                                
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Leave')): ?>
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                                data-size="lg"
                                                                data-url="<?php echo e(URL::to('leave/' . $leave->id . '/edit')); ?>"
                                                                data-ajax-popup="true" data-size="md"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-title="<?php echo e(__('Edit Leave')); ?>"
                                                                data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                
                                            <?php else: ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Edit Leave')): ?>
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                            data-size="lg"
                                                            data-url="<?php echo e(URL::to('leave/' . $leave->id . '/edit')); ?>"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="<?php echo e(__('Edit Leave')); ?>"
                                                            data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('Delete Leave')): ?>
                                                <div class="action-btn bg-danger ms-2">
                                                    <?php echo Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['leave.destroy', $leave->id],
                                                        'id' => 'delete-form-' . $leave->id,
                                                    ]); ?>

                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                        data-bs-toggle="tooltip" title=""
                                                        data-bs-original-title="Delete" aria-label="Delete"><i
                                                            class="ti ti-trash text-white"></i></a>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        </span>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on('change', '#employee_id', function() {
            var employee_id = $(this).val();
            $.ajax({
                url: '<?php echo e(route('leave.jsoncount')); ?>',
                type: 'POST',
                data: {
                    "employee_id": employee_id,
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function(data) {
                    $('#leave_type_id').empty();
                    $('#leave_type_id').append(
                        '<option value=""><?php echo e(__('Select Leave Type')); ?></option>');
                    $.each(data, function(key, value) {
                        if (value.total_leave >= value.days) {
                            $('#leave_type_id').append('<option value="' + value.id +
                                '" disabled>' + value.title + '&nbsp(' + value.total_leave +
                                '/' + value.days + ')</option>');
                        } else {
                            $('#leave_type_id').append('<option value="' + value.id + '">' +
                                value.title + '&nbsp(' + value.total_leave + '/' + value
                                .days + ')</option>');
                        }
                    });
                }
            });
        });
    </script>

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
                            html += '<div class="row mt-2"> <div class="col-8">' + data[i]
                                .employee.name + '</div>'
                            if (data[i].status == 'Pending') {
                                html +=
                                    '<div class="col-4 badge bg-warning p-2 px-3 rounded status-badge5">' +
                                    data[i].status + '</div>'
                            } else if (data[i].status == 'Approved') {
                                html +=
                                    '<div class="col-4 badge bg-success p-2 px-3 rounded status-badge5">' +
                                    data[i].status + '</div>'
                            } else if (data[i].status == 'Waiting') {
                                html +=
                                    '<div class="col-4 badge bg-info p-2 px-3 rounded status-badge5">' +
                                    data[i].status + '</div>'
                            } else {
                                html +=
                                    '<div class="col-4 badge bg-danger p-2 px-3 rounded status-badge5">' +
                                    data[i].status + '</div>'
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\joki\jokiweb\hrsystem\main_file_2\main_file\resources\views/leave/index.blade.php ENDPATH**/ ?>