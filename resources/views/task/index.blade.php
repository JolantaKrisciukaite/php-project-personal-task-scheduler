@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">

                        <h3 class="titleMenu">Tasks</h3>

                        <div>
                            <form action="{{ route('task.index') }}" method="get" class="sort-form">
                                <fieldset>
                                    <legend>Sort by</legend>
                                    <div>
                                        <label>Task name</label>
                                        <input type="radio" name="sort_by" value="task_name" @if ('task_name' == $sort) checked @endif>
                                        <label>Status id</label>
                                        <input type="radio" name="sort_by" value="status_id" @if ('status_id' == $sort) checked @endif>
                                    </div>
                                </fieldset>

                                <fieldset class="direction">
                                    <legend>Direction</legend>
                                    <div>
                                        <label>Asc</label>
                                        <input type="radio" name="dir" value="asc" @if ('asc' == $dir) checked @endif>
                                        <label>Dsc</label>
                                        <input type="radio" name="dir" value="desc" @if ('desc' == $dir) checked @endif>
                                    </div>
                                </fieldset>
                                <button class="addButtonCreate" type="submit">Sort</button>
                                <a href="{{ route('task.index') }}" class="aButton">Clear</button></a>
                            </form>

                            <form action="{{ route('task.index') }}" method="get" class="sort-form">
                                <fieldset class="filterBy">
                                    <legend>Filter by</legend>
                                    <select class="index" name="statuse_id"><br>
                                        @foreach ($statuses as $statuse)
                                            <option value="{{ $statuse->id }}" @if($defaultTask == $statuse->id) selected @endif>
                                                Name: {{ $statuse->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </fieldset>
                                <button class="addButtonCreate" type="submit">Filter</button>
                                <a href="{{ route('task.index') }}" class="aButton">Clear</button></a>
                            </form>

                            <form action="{{ route('task.index') }}" method="get" class="sort-form">
                                <fieldset class="searchBy">
                                    <legend>Search by</legend>
                                    <input placeholder="Serach by task" type="text" class="index" name="s" value="{{$s}}">
                                </fieldset>
                                <button class="addButtonCreate" type="submit" name="do_search" value="1">Search</button>
                                <a href="{{ route('task.index') }}" class="aButton">Clear</button></a>
                            </form>
                        </div>
                    </div>

                <div class="pager-links">
                {{ $tasks->links() }}
                </div>

                    <div class="card-body">

                        @forelse ($tasks as $task)

                        <div class="photo"> 
                            @if ($task->photo)
                            <img src="{{$task->photo}}">
                            @else
                            <img src="{{asset('noImage.jpg')}}">
                            @endif
                        </div>

                            <div class="index">Task name: {{ $task->task_name }}</div>
                            <div class="index">Task description: {{ $task->task_description }}</div>
                            <div class="index">Status id: {{ $statuse->name }}</div>
                            <div class="index">Add date: {{ $task->add_date }}</div>
                            <div class="index">Completed date: {{ $task->completed_date }}</div>
                            <form method="POST" action="{{ route('task.destroy', [$task]) }}">
                                <a href="{{route('task.show',[$task])}}" class="addButtonCreate">More info</a>
                                <a href="{{ route('task.edit', [$task]) }}" class="editButton">Edit</a>
                                @csrf
                                <button class="deleteButton" type="submit">Delete</button>
                            </form><br>

                            @empty 
                            <h3 class="title">No Results 😛</h3>
                        @endforelse

                    </div>
                <div class="pager-links">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
@endsection


