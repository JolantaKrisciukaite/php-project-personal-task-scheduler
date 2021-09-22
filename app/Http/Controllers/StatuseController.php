<?php

namespace App\Http\Controllers;

use App\Models\Statuse;
use App\Models\Task;
use Illuminate\Http\Request;
use Validator;

class StatuseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $statuses = Statuse::orderBy('name', 'asc') -> paginate(10)->withQueryString();

        $dir = 'asc';
        $sort = 'name';
        $defaultStatuse = 0;
        $s = '';

        // Rušiavimas

        if ($request -> sort_by && $request -> dir) {

            if ('name'== $request -> sort_by && 'asc'== $request -> dir) {
                $statuses = Statuse::orderBy('name') -> paginate(10)->withQueryString();
            } 
            
            elseif ('name'== $request -> sort_by && 'desc'== $request -> dir) {
                $statuses = Statuse::orderBy('name', 'desc') -> paginate(10)->withQueryString();
                $dir = 'desc';
            } 
            
            else {
                $statuse = Statuse::paginate(10)->withQueryString();
            }
        }

        else {
            $statuses = Statuse::paginate(10)->withQueryString();
        }

        return view('statuse.index', [
            'statuses' => $statuses,
            'dir' => $dir,
            'sort' => $sort,
            'defaultStatuse' => $defaultStatuse,
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
        return view('statuse.create');
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
            'statuse_name' => ['required', 'min:3', 'max:128'],
        ],
        );

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
 
        $statuse = new Statuse;
        $statuse->name = $request->statuse_name;
        $statuse->save();
        return redirect()->route('statuse.index')->with('success_message', 'New Statuse created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statuse  $statuse
     * @return \Illuminate\Http\Response
     */
    public function show(Statuse $statuse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Statuse  $statuse
     * @return \Illuminate\Http\Response
     */
    public function edit(Statuse $statuse)
    {
        return view('statuse.edit', ['statuse' => $statuse]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Statuse  $statuse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Statuse $statuse)
    {
        $validator = Validator::make(
            $request->all(),
        [
            'statuse_name' => ['required', 'min:3', 'max:128'],
        ],
        [
            'statuse_name.min' => 'Min. 3 symbols required.',
            'statuse_name.max' => 'Max. 128 symbols required.',
        ]
        );

        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }

        $statuse->name = $request->statuse_name;
        $statuse->save();
        return redirect()->route('statuse.index')->with('success_message', 'Statuse updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statuse  $statuse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Statuse $statuse)
    {
        
        if($statuse->statuseHasTasks->count()){
            return redirect()->route('statuse.index')->with('info_message', 'Couldn\'t delete - Statuse still has active Tasks.');
        }
        $statuse->delete();
        return redirect()->route('statuse.index')->with('success_message', 'Statuse deleted successfully.');
    }

}



