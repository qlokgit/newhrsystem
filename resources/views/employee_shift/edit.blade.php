
{{ Form::model($employeeShift, ['route' => ['employee_shift.update', $employeeShift->id], 'method' => 'PUT']) }}
<div class="modal-body">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Name')]) }}
                </div>
                @error('name')
                    <span class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
                {{ Form::label('initial', __('Initial'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('initial', null, ['class' => 'form-control', 'placeholder' => __('Enter Initial')]) }}
                </div>
                @error('initial')
                    <span class="invalid-initial" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                {{ Form::label('color', __('color'), ['class' => 'form-label']) }}
                <div class="form-color-user">
                    {{ Form::color('color', null, ['class' => 'form-control', 'placeholder' => __('Enter color')]) }}
                </div>
                @error('color')
                    <span class="invalid-name" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="row col-12">
                <div class="form-group col-6">
                    {{ Form::label('time_start', __('Time Start'), ['class' => 'form-label']) }}
                    <div class="form-time_start-user">
                        {{ Form::time('time_start', null, ['class' => 'form-control', 'placeholder' => __('Enter Time Start')]) }}
                    </div>
                    @error('time_start')
                        <span class="invalid-name" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-6">
                    {{ Form::label('time_end', __('Time End'), ['class' => 'form-label']) }}
                    <div class="form-time_end-user">
                        {{ Form::time('time_end', null, ['class' => 'form-control', 'placeholder' => __('Enter Time End')]) }}
                    </div>
                    @error('time_end')
                        <span class="invalid-name" role="alert">
                            <strong class="text-danger">{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
