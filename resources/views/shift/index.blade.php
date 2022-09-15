@extends('layouts.admin')

@section('page-title')
    {{ __('Shift Roster') }}
@endsection


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Shift Roster ') }}</li>
@endsection
@push('css-page')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            box-sizing: border-box;
            display: inline-block;
            margin: 0;
            position: relative;
            vertical-align: middle;
            width: 100% !important;
            margin-top: 2px;
        }
    </style>
    {{-- <link rel="stylesheet" href="{{ asset('libs/select2/dist/css/select2.min.css') }}"> --}}
@endpush
@section('content')
    @php
        $month = [];
        for ($m = 1; $m <= 12; $m++) {
            $month[] = [
                'name' => date('F', mktime(0, 0, 0, $m, $m, $filter['year'])),
                'month' => date('d', mktime(0, 0, 0, $m, $m, $filter['year'])),
            ];
        }
    @endphp
    {{-- @dd($month) --}}
    <div class="card py-2">
        <form action="">
            <div class="row d-flex align-items-center">
                <div class="form-group col-2">
                    <label for="exampleFormControlSelect1">Employee</label>
                    <select class="form-control" name="employee">
                        <option value="">All</option>
                        @foreach ($filter['employees'] as $item)
                            <option value={{ $item->id }} {{ $item->id == $filter['employee'] ? 'selected' : '' }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-2">
                    <label for="exampleFormControlSelect1">Department</label>
                    <select class="form-control" name="department">
                        <option value="">All</option>
                        @foreach ($departments as $item)
                            <option value={{ $item->id }} {{ $item->id == $filter['department'] ? 'selected' : '' }}>
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-2">
                    <label for="exampleFormControlSelect1">Month</label>
                    <select class="form-control" name="month">
                        @foreach ($month as $item)
                            <option value={{ $item['month'] }} {{ $item['month'] == $filter['month'] ? 'selected' : '' }}>
                                {{ $item['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-2">
                    <label for="exampleFormControlSelect1">Year</label>
                    <select class="form-control" name="year">
                        @for ($year = date('Y'); $year < 2030; $year++)
                            <option value={{ $year }} {{ $year == $filter['year'] ? 'selected' : '' }}>
                                {{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-2">
                    <input type="submit" value="Filter" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
    <button type="button" class="btn btn-primary align-items-center d-flex mb-3"
        style="width:200px" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i class="ti ti-plus"></i> Add Shift Roster
    </button>
    

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('shift.store') }}" method="post">
                    @csrf
                    <div class="p-2">
                        <div class="card p-3">
                            <h6>Add Shift Roster</h6>
                            <div class="alert alert-info mt-5" role="alert">
                                <i class="fa fa-info-circle"></i> The existing shift will be overidden
                            </div>
                            <div class="modal-body p-0">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Department</label>
                                            <select class="form-control" name="department_id" id="department_id">
                                                <option>Nothing Selected</option>
                                                @foreach ($departments as $item)
                                                    <option value={{ $item->id }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group d-flex flex-column">
                                            <label for="exampleFormControlSelect1">Employees</label>
                                            <select class="form-control select2-multiple" multiple="multiple"
                                                name="employee_id[]" id="employee_id">
                                                <option>Nothing Selected</option>
                                                {{-- @foreach ($employees as $item)
                                                    <option value={{ $item->id }}>{{ $item->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Employee Shift</label>
                                            <select class="form-control" name="employee_shift_id">
                                                <option value="">Nothing Selected</option>
                                                @foreach ($employeeShift as $item)
                                                    <option value={{ $item->id }}>
                                                        {{ $item->name . ' ( ' . date('H:i', strtotime($item->time_start)) . ' - ' . date('H:i', strtotime($item->time_end)) . ' )' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="mb-3">Assign Shift
                                                    By</label>
                                                <div class="d-flex">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input assign_shift_by" type="radio"
                                                            name="assign_shift_by" value="date" checked>
                                                        <label class="form-check-label">
                                                            Date
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input assign_shift_by" type="radio"
                                                            name="assign_shift_by" value="month">
                                                        <label class="form-check-label">
                                                            Month
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-5 input-date">
                                        <div class="form-group">
                                            <label for="validationDefault01">Date</label>
                                            <input type="date" name="dates" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-5 month-year">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="validationDefault01">Month</label>
                                                    <select class="form-control" name="month" id="month">
                                                        <option>Nothing Selected</option>
                                                        @foreach ($month as $key => $item)
                                                            <option value={{ $key }}>{{ $item['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="validationDefault01">Year</label>
                                                    <select class="form-control" name="year" id="year">
                                                        <option>Nothing Selected</option>
                                                        @for ($year = date('Y'); $year < 2030; $year++)
                                                            <option value={{ $year }}>{{ $year }}</option>
                                                        @endfor
                                                        {{-- @foreach ($years as $key => $item)
                                                    @endforeach --}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-4">
                                        <div class="form-group d-flex align-items-center">
                                            <input name="send_email" class="form-check-input mt-0 me-2" type="checkbox"
                                                value="send-email" aria-label="Checkbox for following text input">
                                            Send Email
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
                        <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header card-body table-border-style">
            <div class="row mb-2 d-flex align-items-center">
                @foreach ($employeeShift as $item)
                    <div class="fw-bold col-1 me-2 text-white p-1"
                        style="border-radius:8px;background-color: {{ $item->color }}">{{ $item->initial }}:
                        {{ $item->name }}</div>
                @endforeach
                <div class="col-1">
                    <i class="fa fa-star text-warning"></i> : Holiday
                </div>
            </div>
            @php
                $list = [];
                $month = $filter['month'];
                $year = $filter['year'];
                
                for ($d = 1; $d <= 31; $d++) {
                    $time = mktime(12, 0, 0, $month, $d, $year);
                    if (date('m', $time) == $month) {
                        $list[] = [
                            'id' => $d,
                            'date' => date('d', $time),
                            'dateInitial' => date('D', $time),
                            'day' => date('l', $time),
                            'year' => date('d-m-Y', $time),
                            'yearFormat' => date('Y-m-d', $time),
                        ];
                    }
                }
            @endphp
            <div class="table-responsive">
                <table class="table" id="pc-dt-simple">
                    <thead>
                        <tr>
                            <th>{{ __('Employee') }}</th>

                            @foreach ($list as $item)
                                <th class="text-center">
                                    {{ $item['date'] }} <br> {{ $item['dateInitial'] }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $id => $item)
                            <tr class="text-center">
                                <td>{{ $item->name }}</td>
                                @php
                                    $detailShift = !empty($item->shift->first()->detailShift) ? $item->shift->first()->detailShift : [];
                                    $checkDetailArray = !empty($detailShift) ? $detailShift->toArray() : [];
                                    // $countDetailShift = !empty($detailShift) ? count($detailShift) - 1 : 0;
                                @endphp
                                {{-- @dd($item->shift->first()->detailShift->get()) --}}
                                @foreach ($list as $key => $date)
                                    <td>
                                        @php
                                            $checked = array_search($date['yearFormat'], array_column($checkDetailArray, 'date'));
                                        @endphp
                                        {{-- {{$checked}} --}}
                                        @if (is_numeric($checked))
                                            @php
                                                $checkShift = !empty($item->shift[$id]->detailShift[$id]->employeeShift);
                                                $shift = $checkShift ? $item->shift[$id]->detailShift[$id]->employeeShift : '';
                                                $idShift = !empty($item->shift[$id]->detailShift[$id]->id) ? $item->shift[$id]->detailShift[$id]->id : '';
                                                $getDateShift = !empty($detailShift[$key]->date) ? $detailShift[$key]->date : '';
                                            @endphp
                                            <a href="#" class="edit-shift" data-bs-toggle="modal"
                                                data-bs-target="#editShift" data-employeeId="{{ $item->id }}"
                                                data-id="{{ $checkDetailArray[$checked]['id'] }}"
                                                data-employeeName="{{ $item->name }}"
                                                data-employeeType="{{ $item->user->type }}"
                                                data-year="{{ $date['yearFormat'] }}" data-day="{{ $date['day'] }}"
                                                data-selectYear="{{ $date['year'] }}">
                                                <div class="fw-bold text-white p-1 rounded "style="background-color:{{$checkDetailArray[$checked]['employee_shift']['color']}}">
                                                    {{$checkDetailArray[$checked]['employee_shift']['initial']}}
                                                </div>
                                            </a>

                                            <div class="modal fade" id="editShift" tabindex="-1"
                                                aria-labelledby="editShiftLabel" aria-hidden="true">
                                                <div class="modal-dialog">

                                                    <div class="modal-content">
                                                        <form action="{{ route('edit.shift.roaster') }}" method="POST">
                                                            {{-- @method('PUT') --}}
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Employee Shift
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h5 class="modal-title edit-text-date text-start">
                                                                </h5>
                                                                <div class="mt-2 d-flex">
                                                                    <img src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png"
                                                                        style="border-radius:100%;width:40px;height:40px"
                                                                        alt="" srcset="">
                                                                    <div style="margin-left:8px" class="text-start">
                                                                        <h6 style="font-size:12px"
                                                                            id="edit-employee-name">
                                                                        </h6>
                                                                        <h6 style="font-size:12px"
                                                                            id="edit-employee-type">
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-4">
                                                                    <div class="form-group text-start">
                                                                        <label class="mb-2">Employee Shift</label>
                                                                        <select class="form-control"
                                                                            name="employee_shift_id">
                                                                            <option value="">Nothing Selected
                                                                            </option>
                                                                            @foreach ($employeeShift as $val)
                                                                                <option value={{ $val->id }}
                                                                                    {{ $item->shift->first()->detailShift->first()->employeeShift->id == $val->id ? 'selected' : '' }}>
                                                                                    {{ $val->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="employee_id"
                                                                    id="edit_employee_ids" value="">
                                                                <input type="hidden" name="select_year"
                                                                    id="edit_select_year" value="">
                                                                <input type="hidden" name="shift_id" id="shift_id"
                                                                    value="">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>

                                                                <button type="submit" class="btn btn-primary">Save
                                                                    changes</button>
                                                            </div>
                                                        </form>
                                                        <form
                                                            action="{{ route('delete.shift.roaster', $item->shift->first()->detailShift->first()->id) }}"
                                                            method="post">
                                                            @method('DELETE')
                                                            @csrf
                                                            <input type="hidden" name="shift_id_d" id="shift_id_d">
                                                            <input type="submit" value="DELETE"
                                                                style="float: right;margin-right: 20px;margin-bottom: 20px;"
                                                                class="btn btn-danger">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($date['day'] == 'Sunday')
                                            <a href="#" class="assign-shift">
                                                <i class="fa fa-star text-warning"></i>
                                            </a>
                                        @else
                                            <a href="#" class="assign-shift" data-bs-toggle="modal"
                                                data-bs-target="#assignShift" data-employeeId="{{ $item->id }}"
                                                data-employeeName="{{ $item->name }}"
                                                data-employeeType="{{ $item->user->type }}"
                                                data-year="{{ $date['yearFormat'] }}" data-day="{{ $date['day'] }}"
                                                data-selectYear="{{ $date['year'] }}">
                                                <i class="fa fa-plus text-black"></i>
                                            </a>
                                        @endif

                                    </td>

                                    <div class="modal fade" id="assignShift" tabindex="-1"
                                        aria-labelledby="assignShiftLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('set.employee.department') }}" method="POST">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Employee Shift
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5 class="modal-title text-date">
                                                        </h5>
                                                        <div class="mt-2 d-flex">
                                                            <img src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png"
                                                                style="border-radius:100%;width:40px;height:40px"
                                                                alt="" srcset="">
                                                            <div style="margin-left:8px">
                                                                <h6 style="font-size:12px" id="employee-name"></h6>
                                                                <h6 style="font-size:12px" id="employee-type"></h6>
                                                            </div>
                                                        </div>
                                                        <div class="mt-4">
                                                            <div class="form-group">
                                                                <label class="mb-2">Employee Shift</label>
                                                                <select class="form-control" name="employee_shift_id">
                                                                    <option value="">Nothing Selected</option>
                                                                    @foreach ($employeeShift as $val)
                                                                        <option value={{ $val->id }}>
                                                                            {{ $val->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="employee_id" id="employee_ids"
                                                            value="">
                                                        <input type="hidden" name="select_year" id="select_year"
                                                            value="">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            changes</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2-multiple').select2({
                dropdownParent: "#exampleModal",
                placeholder: "Select Employee"
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".assign-shift", function() {
                // $('.assign-shift').click(function() {
                var id = $(this).attr('data-employeeId');
                var name = $(this).attr("data-employeeName")
                var type = $(this).attr("data-employeeType");
                var year = $(this).attr('data-year');
                var selectYear = $(this).attr('data-selectYear');
                var day = $(this).attr('data-day');
                $('#employee-name').html(name)
                $('#employee-type').html(type)
                $('.text-date').html(`Date: ${selectYear} (${day})`)
                document.getElementById("employee_ids").value = id;
                document.getElementById("select_year").value = year;
            });
        });

        $(document).ready(function() {
            $(document).on("click", ".edit-shift", function() {
                // $('.assign-shift').click(function() {
                var id = $(this).attr('data-employeeId');
                var shiftId = $(this).attr('data-id');
                var name = $(this).attr("data-employeeName")
                var type = $(this).attr("data-employeeType");
                var year = $(this).attr('data-year');
                var selectYear = $(this).attr('data-selectYear');
                var day = $(this).attr('data-day');
                $('#edit-employee-name').html(name)
                $('#edit-employee-type').html(type)
                $('.edit-text-date').html(`Date: ${selectYear} (${day})`)
                document.getElementById("edit_employee_ids").value = id;
                document.getElementById("shift_id_d").value = shiftId;
                document.getElementById("edit_select_year").value = year;
                document.getElementById("shift_id").value = shiftId;
                console.log(shiftId);
            });
        });

        $('#department_id').change(function() {
            var id = $(this).val();

            $.ajax({
                url: "/get-employee-by-department/" + id,
                method: "GET",
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;
                    // html += '<option disabled>Select Employee</option>';
                    for (i = 0; i < data.data.length; i++) {
                        html += '<option value=' + data.data[i].id + '>' + data.data[i]
                            .name + '</option>';
                    }
                    $('#employee_id').html(html);
                }
            });
        });

        $('.month-year').css('display', 'none');
        $('.assign_shift_by').change(function() {
            let assignShift = $("input[name='assign_shift_by']:checked").val();
            if (assignShift == 'month') {
                $('.input-date').css('display', 'none');
                $('.month-year').css('display', 'block');
            } else {
                $('.input-date').css('display', 'block');
                $('.month-year').css('display', 'none');
            }
        })
    </script>
@endpush
