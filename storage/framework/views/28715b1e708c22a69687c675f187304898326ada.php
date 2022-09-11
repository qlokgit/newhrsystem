

<?php
   $logo = asset(Storage::url('uploads/logo/'));
   $company_logo = \App\Models\Utility::GetLogo();
   ?>


<?php $__env->startSection('content'); ?>
    <div class="row">

    <div class="col-lg-10">
        <div class="container">
            <div>

                    <div class="text-md-end mb-2"style="margin-right: -44px;">
                       
                        <a href="<?php echo e(route('contract.download.pdf',\Crypt::encrypt($contract->id))); ?>" class="btn btn-sm btn-primary btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Download')); ?>" target="_blanks"><i class="ti ti-download text-white"></i></a>
                        
                    </div>

                <div class="card mt-5" id="printTable" style="margin-left: 180px;margin-right: -57px;">
                    <div class="card-body">
                        <div class="row invoice-title mt-2">
                            <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 ">
                                <img  src="<?php echo e($img); ?>" style="max-width: 150px;"/>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                                <h3 class="invoice-number"><?php echo e(\Auth::user()->contractNumberFormat($contract->id)); ?></h3>
                            </div>    
                        </div>
                        <div class="row align-items-center mb-4">
                            
                            <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                                <div class="col-lg-6 col-md-8 mb-3">
                                    <h6 class="d-inline-block m-0 d-print-none"><?php echo e(__('Contract Type  :')); ?></h6>
                                    <span class="col-md-8"><span class="text-md"><?php echo e($contract->contract_type->name); ?></span></span>
                                </div>
                                <div class="col-lg-6 col-md-8">
                                <h6 class="d-inline-block m-0 d-print-none"><?php echo e(__('Contract Value   :')); ?></h6>
                                <span class="col-md-8"><span class="text-md"><?php echo e(Auth::user()->priceFormat($contract->value)); ?></span></span>
                            </div>
                           
  
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <div>
                                    <div class="float-end">
                                        <div class="">
                                            <h6 class="d-inline-block m-0 d-print-none"><?php echo e(__('Start Date   :')); ?></h6>
                                            <span class="col-md-8"><span class="text-md"><?php echo e(Auth::user()->dateFormat($contract->start_date)); ?></span></span>
                                        </div>
                                        <div class="mt-3">
                                            <h6 class="d-inline-block m-0 d-print-none"><?php echo e(__('End Date   :')); ?></h6>
                                            <span class="col-md-8"><span class="text-md"><?php echo e(Auth::user()->dateFormat($contract->end_date)); ?></span></span>
                                        </div>
                                       
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                        <p data-v-f2a183a6="">
                            
                            <div><?php echo $contract->description; ?></div>
                            <br>
                            <div><?php echo $contract->contract_description; ?></div>
                        </p>

                        <div class="row">

                            <div class="col-6" style="width: 500px;">
                                <div>

                                    <img width="200px" src="<?php echo e($contract->company_signature); ?>" >
                                </div>
                                <div>

                                    <h5 class="mt-auto"><?php echo e(__('Company Signature')); ?></h5>
                                </div>
                            </div> 
                            <div class="col-6 text-end">
                                <img width="150px" src="<?php echo e($contract->employee_signature); ?>" >
                                <h5 class="mt-auto"><?php echo e(__('Employee Signature')); ?></h5>
                            </div> 
                        </div>
                    </div>


                </div>
             
            </div>
        </div>
    </div>

    
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.contractheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\contracts\contract_view.blade.php ENDPATH**/ ?>