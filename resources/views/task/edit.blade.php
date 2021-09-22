@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
           <div class="card">
               <div class="titleReservoir">Edit Task</div>

               <div class="card-body">
                <form method="POST" action="{{route('task.update',[$task])}}" enctype="multipart/form-data">

                    <div class="form-group">
                        <label>Task name:</label>
                        <input type="text" name="task_name" class="form-control" value="{{old('task_name', $task->task_name)}}">
                    </div>

                    <div class="form-group">
                        <label>Task description:</label>
                        <textarea id="summernote" type="text" name="task_description" class="form-control"
                        value="{{ old('task_description', $task->task_description) }}">{{$task->task_description}}</textarea>
                    </div>

                    <select class="index" name="statuse_id"><br>
                        @foreach ($statuses as $statuse)
                            <option value="{{ $statuse->id }}">
                                Name: {{$statuse->name}} 
                            </option>
                        @endforeach
                    </select>

                    <div class="form-group">
                        <label>Add date:</label>
                        <input type="text" name="task_add_date" class="form-control" value="{{old('task_add_date', $task->add_date)}}">
                    </div>

                    <div class="form-group">
                        <div class="small-photo">
                             @if($task->photo)
                                 <img src="{{$task->photo}}">
                                 <label>Delete photo</label>
                                 <input type="checkbox" name="delete_task_photo">
                             @else
                                  <img src="{{asset('noImage.jpg')}}">
                             @endif
                             <p>Photo:</p>
                             <input type="file" name="task_photo">
                         </div>
                     </div>

                    <div class="form-group">
                        <label>Completed date:</label>
                        <input placeholder="Enter task experience" type="text" name="task_completed_date" class="form-control"
                            value="{{ old('task_completed_date', $task->completed_date)}}">
                    </div>
                      
                    @csrf
                    <button class="editButton" type="submit">Edit</button>
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