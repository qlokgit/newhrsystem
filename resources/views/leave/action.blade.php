{{-- {{ Form::open(['url' => 'leave/changeaction', 'method' => 'post']) }}
<div class="modal-body">
        <div class="row">
            <table class="table">
                <tr>
                    <th>{{ __('Employee') }}</th>
                    <td>{{ !empty($employee->name) ? $employee->name : '' }}</td>
                </tr>
                <tr>
                    <th>{{ __('Leave Type ') }}</th>
                    <td>{{ !empty($leavetype->title) ? $leavetype->title : '' }}</td>
                </tr>
                <tr>
                    <th>{{ __('Appplied On') }}</th>
                    <td>{{ \Auth::user()->dateFormat($leave->applied_on) }}</td>
                </tr>
                <tr>
                    <th>{{ __('Start Date') }}</th>
                    <td>{{ \Auth::user()->dateFormat($leave->start_date) }}</td>
                </tr>
                <tr>
                    <th>{{ __('End Date') }}</th>
                    <td>{{ \Auth::user()->dateFormat($leave->end_date) }}</td>
                </tr>
                <tr>
                    <th>{{ __('Leave Reason') }}</th>
                    <td>{{ !empty($leave->leave_reason) ? $leave->leave_reason : '' }}</td>
                </tr>
                <tr>
                    <th>{{ __('Status') }}</th>
                    <td>{{ !empty($leave->status) ? $leave->status : '' }}</td>
                </tr>
                <input type="hidden" value="{{ $leave->id }}" name="leave_id">
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-success" value="{{ __('Approval') }}" name="status">
        <input type="submit" class="btn btn-danger" value="{{ __('Reject') }}" name="status">
    </div>
    {{ Form::close() }} --}}
    {{ Form::open(['url' => 'leave/changeaction', 'method' => 'post']) }}
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <table class="table" id="pc-dt-simple">
                    <tr role="row">
                        <th>{{ __('Employee') }}</th>
                        <td>{{ !empty($employee->name) ? $employee->name : '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Leave Type ') }}</th>
                        <td>{{ !empty($leavetype->title) ? $leavetype->title : '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Appplied On') }}</th>
                        <td>{{ \Auth::user()->dateFormat($leave->applied_on) }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Start Date') }}</th>
                        <td>{{ \Auth::user()->dateFormat($leave->start_date) }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('End Date') }}</th>
                        <td>{{ \Auth::user()->dateFormat($leave->end_date) }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Leave Reason') }}</th>
                        <td>{{ !empty($leave->leave_reason) ? $leave->leave_reason : '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Status') }}</th>
                        <td>{{ !empty($leave->status) ? $leave->status : '' }}</td>
                    </tr>
                    <tr>
                        <th>{{ __('Approved By') }}</th>
                        <td>
                            <div class="row mt-2">
                                <div class="col-8">
    
                                    {{ $hr->hr->name }} <b>(HR)</b>
                                </div>
                                @if ($hr->status == 'Pending')
                                    <div class="col-4 badge bg-warning p-2 px-3 rounded status-badge5">
                                        {{ $hr->status }}</div>
                                @elseif ($hr->status == 'Waiting')
                                    <div class="col-4 badge bg-info p-2 px-3 rounded status-badge5">
                                        {{ $hr->status }}</div>
                                @elseif($hr->status == 'Approved')
                                    <div class="col-4 badge bg-success p-2 px-3 rounded status-badge5">
                                        {{ $hr->status }}</div>
                                @else($hr->status == "Reject")
                                    <div class="col-4 badge bg-danger p-2 px-3 rounded status-badge5">
                                        {{ $hr->status }}</div>
                                @endif
                            </div>
                            @foreach ($approvedLeave as $item)
                                <div class="row mt-2">
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
                                </div>
                            @endforeach
                        </td>
                    </tr>
                    @if ($hr->rejected_by)
                        <tr>
                            <th>{{ __('Rejected By') }}</th>
                            <td>{{ $hr->rejectedBy->name }}</td>
                        </tr>
                    @endif
                    <input type="hidden" value="{{ $leave->id }}" name="leave_id">
                </table>
            </div>
        </div>
    </div>
    {{-- <div class="col-12">
            <input type="submit" class="btn-create badge-success" value="{{ __('Approval') }}" name="status">
            <input type="submit" class="btn-create bg-danger" value="{{ __('Reject') }}" name="status">
        </div> --}}
    @if (\Auth::user()->type == 'hr' || \Auth::user()->type == 'company')
    
        @if ($leave->status == 'Pending')
            <div class="modal-footer">
                <input type="submit" value="{{ __('Approved') }}" class="btn btn-success rounded" name="status">
                <input type="submit" value="{{ __('Reject') }}" class="btn btn-danger rounded" name="status">
            </div>
        @endif
    @endif
    {{ Form::close() }}