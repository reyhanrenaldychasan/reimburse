<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    {{-- <link href="{{ asset('assets/bootstrap-5.3.3/css/bootstrap.css') }}" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> --}}
</head>
<style>
    .struk {
        width: 400px;
    }

    .struk-bensin {
        font-family: "Arial Narrow", Helvetica, sans-serif;
        font-size: 20px;
    }

    .struk-parkir {
        width: 350px;
    }

    .arial {
        font-family: "Arial";
    }

    .fs-23 {
        font-size: 23px;
    }

    .fs-125 {
        font-size: 12.5px;
    }

    .fs-13 {
        font-size: 13px;
    }

    .fs-14 {
        font-size: 14px;
    }

    .mt-min-8 {
        margin-top: -8px;
    }

    .mt-min-6 {
        margin-top: -6px;
    }

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

    .row {
        display: flex;
        flex-wrap: wrap;
    }

    .text-center {
        text-align: center;
    }
</style>

<body>
    @foreach ($reimburse as $item)
        <div>Parkir {{ $item->date }}</div>
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
                    : <b>Rp16.000</b>
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
    @endforeach
</body>

</html>
