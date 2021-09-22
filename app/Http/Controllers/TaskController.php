<?php

namespace App\Http\Controllers;

use App\Models\Statuse;
use App\Models\Task;
use Illuminate\Http\Request;
use Validator;
use PDF;

class TaskController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Task::orderBy('task_name', 'asc') -> paginate(10)->withQueryString();

        $dir = 'asc';
        $sort = 'task_name';
        $defaultTask = 0;
        $statuses = Statuse::orderBy('name') -> get();
        $s = '';


        // Rušiavimas

        if ($request -> sort_by && $request -> dir) {

            if ('task_name'== $request -> sort_by && 'asc'== $request -> dir) {
                $tasks = Task::orderBy('task_name') -> paginate(10)->withQueryString();
            } 
            
            elseif ('task_name'== $request -> sort_by && 'desc'== $request -> dir) {
                $tasks = Task::orderBy('task_name', 'desc') -> paginate(10)->withQueryString();
                $dir = 'desc';
            } 
            
            elseif ('statuse_id'== $request -> sort_by && 'asc'== $request -> dir) {
                $tasks = Task::orderBy('statuse_id') -> paginate(10)->withQueryString();
                $sort = 'statuse_id';
            } 
            
            elseif ('statuse_id'== $request -> sort_by && 'desc'== $request -> dir) {
                $tasks = Task::orderBy('statuse_id', 'desc') -> paginate(10)->withQueryString();
                $dir = 'desc';
                $sort = 'statuse_id';
            } 
            
            else {
                $task = Task::paginate(10)->withQueryString();
            }
        }

        // Filtravimas

        elseif ($request -> task_id) {
            $tasks = Task::where('task_id', (int)$request -> task_id) -> paginate(10)->withQueryString();
            $defaultMember = (int)$request -> task_id;
        }

        // Paieška

        elseif ($request -> s) {
            $tasks = Task::where('task_name', 'like', '%'.$request -> s.'%') -> paginate(10)->withQueryString();
            $s = $request -> s;
        } 
        
        elseif ($request -> do_search) {
            $tasks = Task::where('task_name', 'like', '') -> paginate(10)->withQueryString();
        } 
        
        else {
            $tasks = Task::paginate(10)->withQueryString();
        }

        return view('task.index', [
            'tasks' => $tasks,
            'dir' => $dir,
            'sort' => $sort,
            'statuses' => $statuses,
            'defaultTask' => $defaultTask,
            's' => $s
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = Statuse::all();
        $task = Task::orderBy('task_name')->get();
        return view('task.create', ['task' => $task, 'statuses'=>$statuses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'task_name' => ['required', 'min:3', 'max:128'],
            'task_description' => ['required'],
            'statuse_id' => ['required'],
            // 'add_date' => ['required'],
            // 'complete_date' => ['required']
        ],
        );
        
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $task = new Task;

        if ($request->has('task_photo')) {
            $photo = $request->file('task_photo');
            $imageName = 
            $request->task_name. '-' .
            time(). '.' .
            $photo->getClientOriginalExtension();
            $path = public_path() . '/tasks-images/'; // serverio vidinis kelias
            $url = asset('tasks-images/'.$imageName); // url narsyklei (isorinis)
            $photo->move($path, $imageName); // is serverio tmp ===> i public folderi
            $task->photo = $url;
        }

        $task->task_name = $request->task_name;
        $task->task_description = $request->task_description;
        $task->add_date = $request->task_add_date;
        $task->completed_date = $request->task_completed_date;
        $task->statuse_id = $request->statuse_id;
        $task->save();
        return redirect()->route('task.index')->with('success_message', 'New Task created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('task.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $statuses = Statuse::all();
        return view('task.edit', ['task' => $task, 'statuses' => $statuses]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(),
        [   'task_name' => ['required', 'min:3', 'max:128'],
            'task_description' => ['required'],
            'statuse_id' => ['required'],
            // 'add_date' => ['required'],
            // 'complete_date' => ['required']
        ],
        );
        
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $task = new Task;

        if ($request->has('delete_task_photo')) {
            if ($task->photo) {
                $imageName = explode('/', $task->photo);
                $imageName = array_pop($imageName);
                $path = public_path() . '/tasks-images/'.$imageName;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $task->photo = null;
        }

        if ($request->has('task_photo')) {
            if ($task->photo) {
                $imageName = explode('/', $task->photo);
                $imageName = array_pop($imageName);
                $path = public_path() . '/tasks-images/'.$imageName;
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $photo = $request->file('task_photo');
            $imageName =
            $request->task_name. '-' .
            time(). '.' .
            $photo->getClientOriginalExtension();
            $path = public_path() . '/tasks-images/'; // serverio vidinis kelias
            $url = asset('tasks-images/'.$imageName); // url narsyklei (isorinis)
            $photo->move($path, $imageName); // is serverio tmp ===> i public folderi
            $task->photo = $url;
        }

        $task->task_name = $request->task_name;
        $task->task_description = $request->task_description;
        $task->add_date = $request->task_add_date;
        $task->completed_date = $request->task_completed_date;
        $task->statuse_id = $request->statuse_id;
        $task->save();
        return redirect()->route('task.index')->with('success_message', 'Task updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if ($task->photo) {
            $imageName = explode('/', $task->photo);
            $imageName = array_pop($imageName);
            $path = public_path() . '/tasks-images/'.$imageName;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        if($task->taskStatuse->count()){
            return redirect()->route('task.index')->with('info_message', 'Couldn\'t delete - Task still has active Statuses.');
        }
        $task->delete();
        return redirect()->route('task.index')->with('success_message', 'task deleted successfully.');
    }

    public function pdf(Task $task)
    {
        $pdf = PDF::loadView('task.pdf', ['task' => $task]);
        return $pdf->download($task->task_name.'.pdf');
    }

}
