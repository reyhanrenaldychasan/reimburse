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