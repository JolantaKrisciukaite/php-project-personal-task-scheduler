@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">

                    <h3 class="titleReservoir">Create new Status</h3>

                    <div class="card-body">
                        <form method="POST" action="{{ route('statuse.store') }}" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Name:</label>
                                <input placeholder="Enter status name" type="text" name="statuse_name" class="form-control"
                                    value="{{ old('statuse_name') }}">
                            </div>

                            @csrf
                            <button class="addButton" type="submit">Add</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
