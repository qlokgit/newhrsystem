
 <?php $__env->startSection('page-title'); ?>
     <?php echo e(__('Trainig Details')); ?>

 <?php $__env->stopSection(); ?>

 <?php $__env->startSection('breadcrumb'); ?>
     <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
     <li class="breadcrumb-item"><a href="<?php echo e(route('training.index')); ?>"><?php echo e(__('Training List')); ?></a></li>
     <li class="breadcrumb-item"><?php echo e(__('Trainig Details')); ?></li>
 <?php $__env->stopSection(); ?>
 <?php $__env->startSection('content'); ?>
     <div class="col-md-4">
         <div class="card">
             <div class="card-body table-border-style">
                 <div class="table-responsive ">
                     <table class="table ">
                         <tbody>
                             <tr>
                                 <td><?php echo e(__('Training Type')); ?></td>
                                 <td class="text-right"><?php echo e(!empty($training->types) ? $training->types->name : ''); ?>

                                 </td>
                             </tr>
                             <tr>
                                 <td><?php echo e(__('Trainer')); ?></td>
                                 <td class="text-right">
                                     <?php echo e(!empty($training->trainers) ? $training->trainers->firstname : '--'); ?></td>
                             </tr>
                             <tr>
                                 <td><?php echo e(__('Training Cost')); ?></td>
                                 <td class="text-right"><?php echo e(\Auth::user()->priceFormat($training->training_cost)); ?>

                                 </td>
                             </tr>
                             <tr>
                                 <td><?php echo e(__('Start Date')); ?></td>
                                 <td class="text-right"><?php echo e(\Auth::user()->dateFormat($training->start_date)); ?></td>
                             </tr>
                             <tr>
                                 <td><?php echo e(__('End Date')); ?></td>
                                 <td class="text-right"><?php echo e(\Auth::user()->dateFormat($training->end_date)); ?></td>
                             </tr>
                             <tr>
                                 <td><?php echo e(__('Date')); ?></td>
                                 <td class="text-right"><?php echo e(\Auth::user()->dateFormat($training->created_at)); ?></td>
                             </tr>
                         </tbody>
                     </table>
                     <div class="text-sm mt-4 p-2"> <?php echo e($training->description); ?></div>
                 </div>
             </div>
         </div>
     </div>
     <div class="col-md-8">
         <div class="card">
             <div class="card-header card-body">
                 <div class="row">
                     <div class="col-md-12">
                         <h6><?php echo e(__('Training Employee')); ?></h6>
                         <hr>
                         <ul class="list-group list-group-flush">
                             <li class="list-group-item" style="border:0px;">
                                 <div class="d-flex align-items-center">
                                     <a href="<?php echo e(!empty($training->employees) ? (!empty($training->employees->user->avatar) ? asset(Storage::url('uploads/avatar')) . '/' . $training->employees->user->avatar : asset(Storage::url('uploads/avatar')) . '/avatar.png') : asset(Storage::url('uploads/avatar')) . '/avatar.png'); ?>" target="_blank">
                                     <img src="<?php echo e(!empty($training->employees) ? (!empty($training->employees->user->avatar) ? asset(Storage::url('uploads/avatar')) . '/' . $training->employees->user->avatar : asset(Storage::url('uploads/avatar')) . '/avatar.png') : asset(Storage::url('uploads/avatar')) . '/avatar.png'); ?>"
                                         class="user-image-hr-prj ui-w-30 rounded-circle" width="50px" height="50px">
                                     </a>
                                     <div class="media-body px-2 text-sm">
                                         <a href="<?php echo e(route('employee.show', !empty($training->employees) ? \Illuminate\Support\Facades\Crypt::encrypt($training->employees->id) : 0)); ?>"
                                             class="text-dark">
                                             <?php echo e(!empty($training->employees) ? $training->employees->name : ''); ?>

                                        
                                         <?php echo e(!empty($training->employees) ? (!empty($training->employees->designation) ? $training->employees->designation->name : '') : ''); ?>

                                          </a>
                                         <br>
                                     </div>
                                 </div>
                             </li>
                         </ul>
                     </div>
                 </div>
                <div class="row">
                    <?php echo e(Form::model($training, ['route' => ['training.status', $training->id], 'method' => 'post'])); ?>

                         <h6><?php echo e(__('Update Status')); ?></h6>
                         <hr>
                        <div class="row col-md-12">
                            <div class="col-md-6">
                                <input type="hidden" value="<?php echo e($training->id); ?>" name="id">
                                <div class="form-group">
                                 <?php echo e(Form::label('performance', __('Performance'), ['class' => 'col-form-label text-dark'])); ?>

                                 <?php echo e(Form::select('performance', $performance, null, ['class' => 'form-control select'])); ?>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <?php echo e(Form::label('status', __('Status'), ['class' => 'col-form-label text-dark'])); ?>

                                <?php echo e(Form::select('status', $status, null, ['class' => 'form-control select'])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">

                        <div class="form-group">
                             <?php echo e(Form::label('remarks', __('Remarks'), ['class' => 'col-form-label text-dark'])); ?>

                             <?php echo e(Form::textarea('remarks', null, ['class' => 'form-control', 'placeholder' => __('Remarks'), 'rows' => '3'])); ?>

                        </div>
                        <div class="form-group text-end">
                            <input type="submit" value="<?php echo e(__('Save')); ?>" class="btn  btn-primary">
                        </div>
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>
 <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\training\show.blade.php ENDPATH**/ ?>