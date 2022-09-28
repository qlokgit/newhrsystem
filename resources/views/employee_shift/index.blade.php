@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Employee Shift') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Employee Shift') }}</li>
@endsection

@section('action-button')
    {{-- @can('Create Employee Shift') --}}
    <a href="#" data-url="{{ route('employee_shift.create') }}" data-ajax-popup="true"
        data-title="{{ __('Create New Employee Shift') }}" data-bs-toggle="tooltip" title=""
        class="btn btn-sm btn-primary" data-bs-original-title="{{ __('Create') }}">
        <i class="ti ti-plus"></i>
    </a>
    {{-- @endcan --}}
@endsection


@section('content')
    <div class="col-3">
        @include('layouts.hrm_setup')
    </div>
    <div class="col-9">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Employee Shift') }}</th>
                                <th>{{ __('Initial') }}</th>
                                <th>{{ __('Color') }}</th>
                                <th>{{ __('Time Start') }}</th>
                                <th>{{ __('Time End') }}</th>
                                <th width="200px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employeeShift as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->initial }}</td>
                                    <td><div style="width:100%;height:10px;background-color:{{$item->color}}"></div></td>
                                    <td>{{ $item->time_start }}</td>
                                    <td>{{ $item->time_end }}</td>
                                    <td class="Action">
                                        <span>
                                            {{-- @can('Edit Contract Type') --}}
                                                <div class="action-btn btn-info ms-2">
                                                    <a href="#" data-size="md"
                                                        data-url="{{ URL::to('employee_shift/' . $item->id . '/edit') }}"
                                                        data-ajax-popup="true" data-title="{{ __('Edit Employee Shift') }}"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Edit Employee Shift') }}"><i
                                                            class="ti ti-pencil text-white"></i></a>
                                                </div>
                                            {{-- @endcan --}}
                                            {{-- @can('Delete Contract Type') --}}
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['employee_shift.destroy', $item->id]]) !!}
                                                    <a href="#!"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Delete') }}">
                                                        <span class="text-white"> <i class="ti ti-trash"></i></span></a>
                                                    {!! Form::close() !!}
                                                </div>
                                {{-- @endif --}}
                                </span>
                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
