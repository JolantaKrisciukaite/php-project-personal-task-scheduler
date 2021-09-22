@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="titleMenu">Statuses</h3>

                        <div>

                            <form action="{{ route('statuse.index') }}" method="get" class="sort-form">
                                <fieldset>
                                    <legend>Sort by</legend>
                                    <div>
                                        <label>Name</label>
                                        <input type="radio" name="sort_by" value="name" @if ('name' == $sort) checked @endif>
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
                                <a href="{{ route('statuse.index') }}" class="aButton">Clear</button></a>
                            </form>

                        </div>
                    </div>

                    <div class="pager-links">
                        {{ $statuses->links() }}
                    </div>

                    <div class="card-body">
                        @foreach ($statuses as $statuse)

                            <div class="index">Name: {{ $statuse->name }}</div>

                            <form method="POST" action="{{ route('statuse.destroy', $statuse) }}">
                                <a href="{{ route('statuse.edit', [$statuse]) }}" class="editButton">Edit</a>
                                @csrf
                                <button class="deleteButton" type="submit">Delete</button>
                            </form>
                            <br>
                        @endforeach

                    </div>
                    <div class="pager-links">
                        {{ $statuses->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endsection