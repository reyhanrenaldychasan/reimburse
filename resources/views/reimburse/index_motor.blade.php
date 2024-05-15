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
    </style>
@endpush

@section('content')
    <div class="form">
        <form action="{{ route('landing') }}" method="get">
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
                <label for="standup_dates">Add standup</label>
                <div>
                    <select name="standup_dates[]" id="standup_dates" class="form-control select2"
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
        </form>
    </div>
    <br>
    @if($fromDate && $toDate)
        <a target="_blank" href="{{ route('download_pdf', ['from_date' => $fromDate, 'to_date' => $toDate, 'exclude_dates' => $excludeDates]) }}"
            class="btn btn-primary">Download PDF</a>
    @endif
    <br>
    <br>
    <div class="row">
        <div class="col">
            @forelse ($parking as $item)
                <div class="struk struk-parkir">
                    <div class="text-center">
                        <img src="{{ asset('img/logo_parkir.png') }}" class="parkir-img" alt="">
                    </div>
                    <div style="font-size: 12px; margin-top: -20px">
                        <b>Kota Jakarta</b>
                    </div>
                    <div class="mt-min-6" style="font-size: 14px">
                        <b>Jl. H. Agus Salim</b>
                    </div>
                    <div class="row mt-min-6 fs-125">
                        <div class="col-5">
                            <div>
                                <b>Terminal : DKI0109</b>
                            </div>
                        </div>
                        <div class="col-3">
                            <div>
                                No. Tiket
                            </div>
                        </div>
                        <div class="col-4">
                            <div>
                                : {{ $item->parkingNo }}
                            </div>
                        </div>
                    </div>
                    <div class="row mt-min-6 fs-125">
                        <div class="col-5">
                            Kendaraan: <b>MOTOR</b>
                        </div>
                        <div class="col-3">
                            Tarif
                        </div>
                        <div class="col-4">
                            : <b>{{ $item->parkingCost }}</b>
                        </div>
                    </div>
                    <div class="mt-min-6 fs-13">
                        No. Polisi: <b>B6423WSF</b>
                    </div>
                    <div class="row mt-min-6 fs-13">
                        <div class="col-4">
                            Waktu Tiba
                        </div>
                        <div class="col-6">
                            : {{ $item->parkingDate }}
                        </div>
                        <div class="col-2">
                            {{ $item->parkingStartTime }}
                        </div>
                    </div>
                    <div class="row mt-min-6 fs-13">
                        <div class="col-4">
                            Berlaku Sampai
                        </div>
                        <div class="col-6">
                            : {{ $item->parkingDate }}
                        </div>
                        <div class="col-2">
                            {{ $item->parkingEndTime }}
                        </div>
                    </div>
                    <br>
                    <div class="row mt-min-6 fs-125">
                        <div class="col-2">
                            Bank
                        </div>
                        <div class="col-10">
                            : MANDIRI
                        </div>
                    </div>
                    <div class="row mt-min-6 fs-125">
                        <div class="col-2">
                            PAN
                        </div>
                        <div class="col-10">
                            : 6032982859954545
                        </div>
                    </div>
                </div>
                <hr>
            @empty
            @endforelse
        </div>
        <div class="col">
            @forelse ($gas as $value)
                <div class="struk struk-bensin">
                    <div>
                        <span style="font-size: 30px;">SPBU 34-12302</span><br>
                        <span class="fs-23">JLN. SULTAN ISKANDAR MUDA</span>
                    </div>
                    <br>
                    <div class="row arial fs-23">
                        <div class="col">{{ $value->gasDate }}</div>
                        <div class="col text-end">{{ $value->gasTime }}</div>
                    </div>
                    <div class="arial fs-23 mt-min-8">
                        Receipt No. : {{ $value->gasNo }} [copy]
                    </div>
                    <br>
                    <div class="fs-23">
                        <div class="row">
                            <div class="col">Pump No.</div>
                            <div class="col text-end">9</div>
                        </div>
                        <div class="row mt-min-8">
                            <div class="col">Grade</div>
                            <div class="col text-end">PERTAMAX</div>
                        </div>
                        <div class="row mt-min-8">
                            <div class="col">Volume (L)</div>
                            <div class="col text-end arial">2.31</div>
                        </div>
                        <div class="row mt-min-8">
                            <div class="col">Unit Price(Rp./L)</div>
                            <div class="col text-end arial">12950</div>
                        </div>
                        <div class="row mt-min-8">
                            <div class="col">Amount(Rp.)</div>
                            <div class="col text-end arial">30000</div>
                        </div>
                    </div>
                    <br>
                    <div class="fs-23">TERIMA KASIH & SELAMAT JALAN</div>
                </div>
                <hr>
            @empty
            @endforelse
        </div>
        <div class="col">
            @forelse ($lunchs as $item)
                <div class="struk struk-makan">
                    <div class="text-center">
                        <img src="{{ asset('img/logo_makan.png') }}" class="makan-img" alt="">
                    </div>
                    <br>
                    <h1 class="text-center">Rp40.000</h1>
                    <div class="text-center">
                        Berhasil bayar ke <b>Dapoer Cheryl, Menteng Atas</b>
                    </div>
                    <div class="text-center fs-14">
                        Jl. Menteng Atas Selatan 3 No. 34A, Setiabudi, Jakarta 12960
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            Metode Pembayaran
                        </div>
                        <div class="col text-end">
                            <img src="{{ asset('img/logo_gopay.png') }}" style="width: 25px" alt="">
                            <b>GoPay</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Status
                        </div>
                        <div class="col text-end">
                            <b>Berhasil</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Waktu
                        </div>
                        <div class="col text-end">
                            <b>{{ $item->lunchTime }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Tanggal
                        </div>
                        <div class="col text-end">
                            <b>{{ $item->lunchDate }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            ID Transaksi
                        </div>
                        <div class="col text-end">
                            <b>{{ $item->lunchNo }} <img src="{{ asset('img/logo_copy.png') }}" style="width: 25px"
                                    alt=""></b>
                        </div>
                    </div>
                    <div class="lunch-border"></div>
                    <div class="row">
                        <div class="col">
                            Jumlah tagihan
                        </div>
                        <div class="col text-end">
                            <b>40000</b>
                        </div>
                    </div>
                    <div class="lunch-border"></div>
                    <div class="row">
                        <div class="col">
                            <b>Total pembayaran</b>
                        </div>
                        <div class="col text-end" style="font-size: 18px">
                            <b>Rp40.000</b>
                        </div>
                    </div>
                </div>
                <hr>
            @empty
            @endforelse

            @forelse ($overtimes as $item)
                <div class="struk struk-makan">
                    <div class="text-center">
                        <img src="{{ asset('img/logo_makan.png') }}" class="makan-img" alt="">
                    </div>
                    <br>
                    <h1 class="text-center">Rp80.000</h1>
                    <div class="text-center">
                        Berhasil bayar ke <b>Dapoer Cheryl, Menteng Atas</b>
                    </div>
                    <div class="text-center fs-14">
                        Jl. Menteng Atas Selatan 3 No. 34A, Setiabudi, Jakarta 12960
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            Metode Pembayaran
                        </div>
                        <div class="col text-end">
                            <img src="{{ asset('img/logo_gopay.png') }}" style="width: 25px" alt="">
                            <b>GoPay</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Status
                        </div>
                        <div class="col text-end">
                            <b>Berhasil</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Waktu
                        </div>
                        <div class="col text-end">
                            <b>{{ $item->overtimeTime }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            Tanggal
                        </div>
                        <div class="col text-end">
                            <b>{{ $item->overtimeDate }}</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            ID Transaksi
                        </div>
                        <div class="col text-end">
                            <b>{{ $item->overtimeNo }} <img src="{{ asset('img/logo_copy.png') }}" style="width: 25px"
                                    alt=""></b>
                        </div>
                    </div>
                    <div class="lunch-border"></div>
                    <div class="row">
                        <div class="col">
                            Jumlah tagihan
                        </div>
                        <div class="col text-end">
                            <b>80000</b>
                        </div>
                    </div>
                    <div class="lunch-border"></div>
                    <div class="row">
                        <div class="col">
                            <b>Total pembayaran</b>
                        </div>
                        <div class="col text-end" style="font-size: 18px">
                            <b>Rp80.000</b>
                        </div>
                    </div>
                </div>
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
        });

        function updateExcludes() {
            let fromDate = $('#from_date').val();
            let toDate = $('#to_date').val();

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
                    $('#standup_dates').val(null).trigger('change');
                    $('#overtime_dates').val(null).trigger('change');

                    let data = response.data;

                    let htmlString = "";

                    data.forEach(element => {
                        htmlString += `<option value="${element}">${element}</option>`;
                    });

                    console.log(htmlString);

                    $('#exclude_dates').html(htmlString);
                    $('#standup_dates').html(htmlString);
                    $('#overtime_dates').html(htmlString);
                }
            });
        }
    </script>
@endpush
