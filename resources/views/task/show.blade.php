@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="titleReservoir">{{ $task->task_name }}</div>

                    <div class="card-body">
                        <div class="card-show">
                            <div class="tasks">
                                <h6>Task name: {{ $task->task_name }}</h6>
                            </div>
                            <div class="tasks">
                                <h6>Task description: {!! $task->task_description !!}</h6>
                            </div>

                        <div>
                            <a href="{{ route('task.edit', [$task]) }}" class="editButton">Edit</a>
                            <a href="{{ route('task.pdf', [$task]) }}" class="addButtonCreate">Download PDF</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
