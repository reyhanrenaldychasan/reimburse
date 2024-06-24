<div class="row">
    <div class="col-sm-6">
        <div style="margin-bottom: 8px; font-weight: 600; color: #454545">
            {{ $item->startDate1 }}
        </div>
        <div>
            <div class="row">
                <div class="col-sm-3">
                    <img src="{{ asset('img/logo_goride.png') }}" class="logo-goride" alt="">
                </div>
                <div class="col">
                    <div style="font-size: 18px; margin-bottom: 15px; color: #1c1c1c">
                        <b>Stasiun MRT Lebak B...</b>
                    </div>
                    <div>
                        <img src="{{ asset('img/trip_completed.png') }}" style="width: 20px" alt=""> <b
                            style="color: #494949">Trip
                            Completed</b>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div style="font-size: 15px; margin-bottom: 10px; color: #4b4b4b" class="text-end">
                        Rp15.000
                    </div>
                    <div>
                        <a href="#" class="btn btn-success rounded-pill"
                            style="padding: 9px 16px"><b>Reorder</b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div style="margin-bottom: 8px; font-weight: 600; color: #454545">
            {{ $item->startDate2 }}
        </div>
        <div>
            <div class="row">
                <div class="col-sm-3">
                    <img src="{{ asset('img/logo_goride.png') }}" class="logo-goride" alt="">
                </div>
                <div class="col">
                    <div style="font-size: 18px; margin-bottom: 15px; color: #1c1c1c">
                        <b>Wisma Mandiri</b>
                    </div>
                    <div>
                        <img src="{{ asset('img/trip_completed.png') }}" style="width: 20px" alt=""> <b
                            style="color: #494949">Trip
                            Completed</b>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div style="font-size: 15px; margin-bottom: 10px; color: #4b4b4b" class="text-end">
                        Rp15.000
                    </div>
                    <div>
                        <a href="#" class="btn btn-success rounded-pill"
                            style="padding: 9px 16px"><b>Reorder</b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div style="margin-bottom: 8px; font-weight: 600; color: #454545">
            {{ $item->endDate1 }}
        </div>
        <div>
            <div class="row">
                <div class="col-sm-3">
                    <img src="{{ asset('img/logo_goride.png') }}" class="logo-goride" alt="">
                </div>
                <div class="col">
                    <div style="font-size: 18px; margin-bottom: 15px; color: #1c1c1c">
                        @if (!isset($item->isOvertime))
                            <b>MRT Bundaran HI St...</b>
                        @else
                            <b>Cluster Gunung Raya</b>
                        @endif
                    </div>
                    <div>
                        <img src="{{ asset('img/trip_completed.png') }}" style="width: 20px" alt=""> <b
                            style="color: #494949">Trip
                            Completed</b>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div style="font-size: 15px; margin-bottom: 10px; color: #4b4b4b" class="text-end">
                        @if (!isset($item->isOvertime))
                            Rp15.000
                        @else
                            Rp61.000
                        @endif
                    </div>
                    <div>
                        <a href="#" class="btn btn-success rounded-pill"
                            style="padding: 9px 16px"><b>Reorder</b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        @if (!isset($item->isOvertime))
            <div style="margin-bottom: 8px; font-weight: 600; color: #454545">
                {{ $item->endDate2 }}
            </div>
            <div>
                <div class="row">
                    <div class="col-sm-3">
                        <img src="{{ asset('img/logo_goride.png') }}" class="logo-goride" alt="">
                    </div>
                    <div class="col">
                        <div style="font-size: 18px; margin-bottom: 15px; color: #1c1c1c">
                            <b>Cluster Gunung Raya</b>
                        </div>
                        <div>
                            <img src="{{ asset('img/trip_completed.png') }}" style="width: 20px" alt=""> <b
                                style="color: #494949">Trip
                                Completed</b>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div style="font-size: 15px; margin-bottom: 10px; color: #4b4b4b" class="text-end">
                            Rp15.000
                        </div>
                        <div>
                            <a href="#" class="btn btn-success rounded-pill"
                                style="padding: 9px 16px"><b>Reorder</b></a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
