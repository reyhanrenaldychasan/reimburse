@extends('layouts.app')

@push('css-plugins')
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('css-scripts')
    <style>
        .parkir-img {
            width: 130px;
        }

        .makan-img {
            width: 70px;
        }

        .lunch-border {
            border-bottom: 1px dashed #e4e4e4;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .logo-goride {
            width: 100px;
        }
        
    </style>
@endpush

@section('content')
    <div class="form">
        <form action="{{ route('landing') }}" method="get" id="reimburse-form">
            <div class="mb-3">
                <label for="from_date" class="form-label">From</label>
                {{-- <input type="text" class="form-control" id="from_date" aria-describedby="emailHelp" name="from_date"
                    placeholder="yyyy-mm-dd" value="{{ $fromDate }}"> --}}
                <div class="input-group date" data-provide="datepicker" data-date-autoclose="true"
                    data-date-format="yyyy-mm-dd">
                    <input type="text" name="from_date" value="{{ $fromDate }}" class="form-control datepicker"
                        id="from_date" autocomplete="off">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="to_date" class="form-label">To</label>
                <div class="input-group date" data-provide="datepicker" data-date-autoclose="true"
                    data-date-format="yyyy-mm-dd">
                    <input type="text" name="to_date" value="{{ $toDate }}" class="form-control datepicker"
                        id="to_date" autocomplete="off">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="exclude">Exclude Dates</label>
                <div>
                    <select name="exclude_dates[]" id="exclude_dates" class="form-control select2"
                        multiple="multiple"></select>
                </div>
            </div>

            <div class="mb-3">
                <label for="overtime_dates">Add overtime</label>
                <div>
                    <select name="overtime_dates[]" id="overtime_dates" class="form-control select2"
                        multiple="multiple"></select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>

            @if ($fromDate)
                <a href="javascript:;" class="btn btn-primary" id="print">Print</a>
            @endif
        </form>
    </div>
    <br>
    <br>
    <div>
        <table class="table">
            @php
                $no = 1;
            @endphp
            @foreach ($reimburses->transports as $key => $item)
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->tableDesc }}</td>
                    <td>Rp {{ number_format($item->amount,0,',','.') }}</td>
                </tr>
                @php
                    $no++;
                @endphp
            @endforeach
            @foreach ($reimburses->parkings as $item)
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->tableDesc }}</td>
                    <td>Rp {{ number_format($item->amount,0,',','.') }}</td>
                </tr>
                @php
                    $no++;
                @endphp
            @endforeach
            @foreach ($reimburses->lunchs as $item)
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->tableDesc }}</td>
                    <td>Rp {{ number_format($item->amount,0,',','.') }}</td>
                </tr>
                @php
                    $no++;
                @endphp
            @endforeach
            @foreach ($reimburses->dinners as $item)
                <tr>
                    <td>{{ $no }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->tableDesc }}</td>
                    <td>Rp {{ number_format($item->amount,0,',','.') }}</td>
                </tr>
                @php
                    $no++;
                @endphp
            @endforeach
            <tr>
                <td colspan="3" class="text-end">Total</td>
                <td>Rp {{ number_format($reimburses->totalAmount,0,',','.') }}</td>
            </tr>
        </table>
    </div>
    <div class="row">
        <div class="col">
            <div style="width: 840px">
                @forelse ($reimburses->transports as $item)
                    @include('reimburse.transport', ['item' => $item])
                    <hr>
                @empty
                @endforelse
            </div>
            <div style="width: 840px">
                @forelse ($reimburses->parkings as $item)
                    @include('reimburse.parking', ['item' => $item])
                    <hr>
                @empty
                @endforelse
            </div>
        </div>
        <div class="col">
            @forelse ($reimburses->lunchs as $item)
                @include('reimburse.gofood', ['item' => $item])
                <hr>
            @empty
            @endforelse

            @forelse ($reimburses->dinners as $item)
                @include('reimburse.gofood', ['item' => $item])
                <hr>
            @empty
            @endforelse

        </div>
    </div>
@endsection

@push('js-plugins')
    <script src="{{ asset('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@push('js-scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2()

            $('.datepicker').change(function(e) {
                e.preventDefault();

                updateExcludes();
            });

            updateExcludes();

            $("#print").click(function(e) {
                e.preventDefault();

                let baseUrl = "{{ route('print') }}";
                window.open(baseUrl + "?" + $('#reimburse-form').serialize());
            });
        });

        function updateExcludes() {
            let fromDate = $('#from_date').val();
            let toDate = $('#to_date').val();

            let excludeDates = {!! json_encode($excludeDates) !!};
            let overtimeDates = {!! json_encode($overtimeDates) !!};

            if (!fromDate || !toDate) return false;

            $.ajax({
                type: "get",
                url: "{{ route('api.get_dates_between_two_dates') }}",
                data: {
                    from_date: fromDate,
                    to_date: toDate,
                },
                success: function(response) {
                    console.log(response);

                    $('#exclude_dates').val(null).trigger('change');
                    $('#overtime_dates').val(null).trigger('change');

                    let data = response.data;

                    let excludeOpt = "";
                    let overtimeOpt = "";

                    data.forEach(element => {
                        var selected = "";

                        excludeDates.forEach(e => {
                            if (element == e) selected = "selected";
                        });
                        excludeOpt += `<option value="${element}" ${selected}>${element}</option>`;

                        selected = "";

                        overtimeDates.forEach(e => {
                            if (element == e) selected = "selected";
                        });
                        overtimeOpt += `<option value="${element}" ${selected}>${element}</option>`;

                        selected = "";

                    });

                    $('#exclude_dates').html(excludeOpt);
                    $('#overtime_dates').html(overtimeOpt);
                }
            });
        }
    </script>
@endpush
