@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">

                    <h3 class="titleReservoir">Create new Task</h3>

                    <div class="card-body">
                        <form method="POST" action="{{ route('task.store') }}" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Name:</label>
                                <input placeholder="Enter task name" type="text" name="task_name" class="form-control"
                                    value="{{ old('task_name') }}">
                            </div>

                            <div class="form-group">
                                <label>Task description:</label>
                                <textarea id="summernote" type="text" name="task_description" class="form-control"
                               ></textarea>
                            </div>

                            <select class="index" name="statuse_id"><br>
                                @foreach ($statuses as $statuse)
                                    <option value="{{ $statuse->id }}">
                                        Status: {{ $statuse->name }} 
                                    </option>
                                @endforeach
                            </select>
                           
                            <div class="form-group">
                                <label>Add date:</label>
                                <input placeholder="Add task date" type="text" name="task_add_date" class="form-control"
                                    value="{{ old('task_add_date') }}">
                            </div>

                            <div class="form-group">
                                <p>Photo:</p>
                                <input type="file" name="task_photo" class="task_photo">
                            </div>

                            <div class="form-group">
                                <label>Completed date:</label>
                                <input placeholder="Enter task experience" type="text" name="task_completed_date" class="form-control"
                                    value="{{ old('task_completed_date') }}">
                            </div>

                            @csrf
                            <button class="addButtonCreate" type="submit">Add</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>

@endsection