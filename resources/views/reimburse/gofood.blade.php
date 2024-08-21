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
            <b>{{ $item->time }}</b>
        </div>
    </div>
    <div class="row">
        <div class="col">
            Tanggal
        </div>
        <div class="col text-end">
            <b>{{ $item->dateDesc }}</b>
        </div>
    </div>
    <div class="row">
        <div class="col">
            ID Transaksi
        </div>
        <div class="col text-end">
            <b>{{ $item->no }} <img src="{{ asset('img/logo_copy.png') }}" style="width: 25px"
                    alt=""></b>
        </div>
    </div>
    <div class="lunch-border"></div>
    <div class="row">
        <div class="col">
            Jumlah tagihan
        </div>
        <div class="col text-end">
            <b>{{ $item->amount }}</b>
        </div>
    </div>
    <div class="lunch-border"></div>
    <div class="row">
        <div class="col">
            <b>Total pembayaran</b>
        </div>
        <div class="col text-end" style="font-size: 18px">
            <b>{{ number_format($item->amount, 0, ',', '.') }}</b>
        </div>
    </div>
</div>