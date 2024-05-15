@extends('layouts.app')

@section('content')
    <div class="form">
        <form action="" method="get">
            <div class="mb-3">
                <label for="from_date" class="form-label">From</label>
                <input type="text" class="form-control" id="from_date" aria-describedby="emailHelp" name="from_date"
                    placeholder="yyyy-mm-dd">
            </div>
            <div class="mb-3">
                <label for="to_date" class="form-label">To</label>
                <input type="text" class="form-control" id="to_date" name="to_date" placeholder="yyyy-mm-dd">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
