{{-- @extends('layouts.admin')

@section('page-title')
    {{ __('Manage Leave') }}
@endsection

@section('action-button')
    @can('Create Leave')
        <a href="#" data-url="{{ route('leave.create') }}"
            class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true"
            data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ __('Create') }}"
            data-title="{{ __('Create New Leave') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endcan
    <a href="{{ route('leave.export') }}" class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center">
        <i class="ti ti-file-export"></i>
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5></h5>
                    <div class="table-responsive">
                        <table class="table" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    @if (\Auth::user()->type != 'employee')
                                        <th>{{ __('Employee') }}</th>
                                    @endif
                                    <th>{{ __('Leave Type') }}</th>
                                    <th>{{ __('Applied On') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Total Days') }}</th>
                                    <th>{{ __('Leave Reason') }}</th>
                                    <th>{{ __('status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leaves as $leave)
                                    <tr>
                                        @if (\Auth::user()->type != 'employee')
                                            <td>{{ !empty(\Auth::user()->getEmployee($leave->employee_id))? \Auth::user()->getEmployee($leave->employee_id)->name: '' }}
                                            </td>
                                        @endif
                                        <td>{{ !empty(\Auth::user()->getLeaveType($leave->leave_type_id))? \Auth::user()->getLeaveType($leave->leave_type_id)->title: '' }}
                                        </td>
                                        <td>{{ \Auth::user()->dateFormat($leave->applied_on) }}</td>
                                        <td>{{ \Auth::user()->dateFormat($leave->start_date) }}</td>
                                        <td>{{ \Auth::user()->dateFormat($leave->end_date) }}</td>
                                        @php
                                            $startDate = new \DateTime($leave->start_date);
                                            $endDate = new \DateTime($leave->end_date);
                                            $total_leave_days = !empty($startDate->diff($endDate)) ? $startDate->diff($endDate)->days : 0;
                                        @endphp
                                        <td>{{ $total_leave_days }}</td>
                                        <td>{{ $leave->leave_reason }}</td>
                                        <td>
                                            @if ($leave->status == 'Pending')
                                                <div class="badge badge-pill badge-warning status-badge5">{{ $leave->status }}</div>
                                            @elseif($leave->status == 'Approved')
                                                <div class="badge badge-pill badge-success status-badge5">{{ $leave->status }}</div>
                                            @else($leave->status=="Reject")
                                                <div class="badge badge-pill badge-danger status-badge5">{{ $leave->status }}</div>
                                            @endif
                                        </td>
                                        <td class="d-flex">
                                            @if (\Auth::user()->type == 'employee')
                                                @if ($leave->status == 'Pending')
                                                    @can('Edit Leave')
                                                        <a href="#" data-url="{{ URL::to('leave/' . $leave->id . '/edit') }}"
                                                            data-size="lg" data-ajax-popup="true"
                                                            data-title="{{ __('Edit Leave') }}"
                                                            class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"><i
                                                                class="ti ti-pencil"></i></a>
                                                    @endcan
                                                @endif
                                            @else
                                                <a href="#" data-url="{{ URL::to('leave/' . $leave->id . '/action') }}"
                                                    data-size="lg" data-ajax-popup="true"
                                                    data-title="{{ __('Leave Action') }}"
                                                    class="action-btn btn-success me-1 btn btn-sm d-inline-flex align-items-center"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="{{ __('Leave Action') }}"><i class="ti ti-player-play"></i>
                                                </a>
                                                @can('Edit Leave')
                                                    <a href="#" data-url="{{ URL::to('leave/' . $leave->id . '/edit') }}"
                                                        data-size="lg" data-ajax-popup="true"
                                                        data-title="{{ __('Edit Leave') }}"
                                                        class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center"
                                                        title="{{ __('Edit') }}"><i class="ti ti-pencil"></i></a>
                                                @endcan
                                            @endif
                                            @can('Delete Leave')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['leave.destroy', $leave->id], 'id' => 'delete-form-' . $leave->id]) !!}
                                            <a href="#!"
                                                class="action-btn btn-danger me-1 btn btn-sm d-inline-flex align-items-center show_confirm"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="{{ __('Delete') }}">
                                                <i class="ti ti-trash"></i></a>
                                            {!! Form::close() !!}

                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script>
        $(document).on('change', '#employee_id', function() {
            var employee_id = $(this).val();

            $.ajax({
                url: '{{ route('leave.jsoncount') }}',
                type: 'POST',
                data: {
                    "employee_id": employee_id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {

                    $('#leave_type_id').empty();
                    $('#leave_type_id').append(
                        '<option value="">{{ __('Select Leave Type') }}</option>');

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
@endpush --}}

@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Leave') }}
@endsection


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Leave ') }}</li>
@endsection

@section('action-button')
    <a href="{{ route('leave.export') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
        data-bs-original-title="{{ __('Export') }}">
        <i class="ti ti-file-export"></i>
    </a>

    @can('Create Leave')
        <a href="#" id="create_leave" data-url="{{ route('leave.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create New Leave') }}" data-size="lg" data-bs-toggle="tooltip" title=""
            class="btn btn-sm btn-primary" data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endcan
@endsection

@section('content')
    @if (\Auth::user()->type == 'employee')
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
                                        <td>{{ !empty($leave->leave->employees) ? $leave->leave->employees->name : '' }}
                                        </td>
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
                                            @else($leave->status == "Reject")
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
                                                                        <input type="hidden" value="{{ $leave->leave_id }}"
                                                                            name="leaves_id">
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
    @endif
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5> </h5> --}}
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                @if (\Auth::user()->type != 'employee')
                                    <th>{{ __('Employee') }}</th>
                                @endif
                                <th>{{ __('Leave Type') }}</th>
                                <th>{{ __('Applied On') }}</th>
                                <th>{{ __('Start Date') }}</th>
                                <th>{{ __('End Date') }}</th>
                                <th>{{ __('Total Days') }}</th>
                                <th>{{ __('Leave Reason') }}</th>
                                <th>{{ __('status') }}</th>
                                <th width="200px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaves as $leave)
                                <tr>
                                    @if (\Auth::user()->type != 'employee')
                                        <td>{{ !empty(\Auth::user()->getEmployee($leave->employee_id)) ? \Auth::user()->getEmployee($leave->employee_id)->name : '' }}
                                        </td>
                                    @endif
                                    <td>{{ !empty(\Auth::user()->getLeaveType($leave->leave_type_id)) ? \Auth::user()->getLeaveType($leave->leave_type_id)->title : '' }}
                                    </td>
                                    <td>{{ \Auth::user()->dateFormat($leave->applied_on) }}</td>
                                    <td>{{ \Auth::user()->dateFormat($leave->start_date) }}</td>
                                    <td>{{ \Auth::user()->dateFormat($leave->end_date) }}</td>
                                    @php
                                        $startDate = new \DateTime($leave->start_date);
                                        $endDate = new \DateTime($leave->end_date);
                                        $total_leave_days = !empty($startDate->diff($endDate)) ? $startDate->diff($endDate)->days : 0;
                                    @endphp
                                    <td>{{ $leave->total_leave_days }}</td>
                                    <td>{{ $leave->leave_reason }}</td>
                                    <td>
                                        @if ($leave->status == 'Pending')
                                            <div class="badge bg-warning p-2 px-3 rounded status-badge5">
                                                {{ $leave->status }}</div>
                                        @elseif($leave->status == 'Approved')
                                            @php
                                                $status = array_column($leave->approvedLeave->toArray(), 'status');
                                                $checkStatus = count(array_unique($status)) === 1 && end($status) === 'Approved';
                                            @endphp
                                            @if ($checkStatus)
                                                <div class="badge bg-success p-2 px-3 rounded status-badge5">
                                                    Approved</div>
                                            @else
                                                <div class="badge bg-warning p-2 px-3 rounded status-badge5">
                                                    Pending</div>
                                            @endif
                                        @else($leave->status == "Reject")
                                            <div class="badge bg-danger p-2 px-3 rounded status-badge5">
                                                {{ $leave->status }}</div>
                                        @endif
                                    </td>

                                    <td class="Action">
                                        <span>
                                            @if (\Auth::user())
                                            {{-- @if (\Auth::user()->type == 'hr' || \Auth::user()->type == 'company' || \Auth::user()->type == 'employee') --}}
                                                <div class="action-btn bg-success ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                        data-size="lg"
                                                        data-url="{{ URL::to('leave/' . $leave->id . '/action') }}"
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                        title="" data-title="{{ __('Leave Action') }}"
                                                        data-bs-original-title="{{ __('Manage Leave') }}">
                                                        <i class="ti ti-caret-right text-white"></i>
                                                    </a>
                                                </div>
                                                {{-- @if ($leave->status == 'Pending') --}}
                                                    @can('Edit Leave')
                                                        <div class="action-btn bg-info ms-2">
                                                            <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                                data-size="lg"
                                                                data-url="{{ URL::to('leave/' . $leave->id . '/edit') }}"
                                                                data-ajax-popup="true" data-size="md"
                                                                data-bs-toggle="tooltip" title=""
                                                                data-title="{{ __('Edit Leave') }}"
                                                                data-bs-original-title="{{ __('Edit') }}">
                                                                <i class="ti ti-pencil text-white"></i>
                                                            </a>
                                                        </div>
                                                    @endcan
                                                {{-- @endif --}}
                                            @else
                                                @can('Edit Leave')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                            data-size="lg"
                                                            data-url="{{ URL::to('leave/' . $leave->id . '/edit') }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Leave') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan
                                            @endif

                                            @can('Delete Leave')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['leave.destroy', $leave->id],
                                                        'id' => 'delete-form-' . $leave->id,
                                                    ]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                        data-bs-toggle="tooltip" title=""
                                                        data-bs-original-title="Delete" aria-label="Delete"><i
                                                            class="ti ti-trash text-white"></i></a>
                                                    </form>
                                                </div>
                                            @endcan
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
    </div>
@endsection

@push('script-page')
    <script>
        $(document).on('change', '#employee_id', function() {
            var employee_id = $(this).val();

            $.ajax({
                url: '{{ route('leave.jsoncount') }}',
                type: 'POST',
                data: {
                    "employee_id": employee_id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {

                    $('#leave_type_id').empty();
                    $('#leave_type_id').append(
                        '<option value="">{{ __('Select Leave Type') }}</option>');

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
@endpush
