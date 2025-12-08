@extends('templates.app')

@section('content')

<form action="" method="GET">
    @csrf
    <div class="row">
        <div class="col-10">
            <input type="text" name="search_exercise" placeholder="Cari latihan yang di rekomendasikan..." class="form-control">
        </div>
        <div class="col-2">
            <button type="submit" class="btn btn-primary">Cari</button>
        </div>
    </div>
</form>

@endsection

