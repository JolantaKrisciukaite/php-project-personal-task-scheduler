@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="titleReservoir">Edit Status</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('statuse.update', $statuse)}}" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Name:</label>
                                <input type="text" name="statuse_name" class="form-control"
                                    value="{{ old('statuse_name', $statuse->name) }}">
                            </div>

                            @csrf
                            <button class="editButton" type="submit">Edit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection