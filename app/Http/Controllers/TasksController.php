<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Project;

class TasksController extends Controller
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
        $taskList = Task::where('id','>','0');

        $selectedProject = 'all';
        if ($request->input('project_id')){
            $selectedProject = $request->input('project_id');
            if($selectedProject != 'all') {
                $taskList->where('project_id', $selectedProject);
            }
        } 
        $taskList = $taskList->orderBy('priority', 'ASC')->get();

        $projects = ['all' => 'Show All']; 
        foreach (Project::get()->pluck('name', 'id')->all() as $k => $v) {
            $projects[$k] = $v;
        }

        $status = [
            '0' => 'Pending',
            '1' => 'Complete',
            '3' => 'In Progress'
        ];
        return view('task.list', compact('taskList', 'status', 'selectedProject', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $selectedProject = '';
        $projects = Project::get()->pluck('name', 'id');
        return view('task.create', compact('selectedProject','projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'project_id' => 'required',
            'name' => 'required',
            'priority' => 'required', 
            'status' => 'required', 
        ]);

        Task::create([
            'project_id' => $request->get('project_id'),
            'name' => $request->get('name'),
            'priority' => $request->get('priority'),
            'status' => $request->get('status')
        ]);

        return redirect('/')
            ->with('flash_notification.message', 'Tugas Baru Berhasil di Buat')
            ->with('flash_notification.level', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $task = Task::findOrFail($id);
        $projects = Project::get()->pluck('name', 'id');
        $selectedProject = $task->project_id;
        return view('task.edit', compact('selectedProject','projects', 'task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'project_id' => 'required',
            'name' => 'required',
            'priority' => 'required', 
            'status' => 'required'
        ]);
        $task = Task::findOrFail($id);
        $task->fill([
            'project_id' => $request->get('project_id'),
            'name' => $request->get('name'),
            'priority' => $request->get('priority'),
            'status' => $request->get('status')
        ]);
        $task->save();

        return redirect('/')
            ->with('flash_notification.message', 'Task updated successfully')
            ->with('flash_notification.level', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
{
    $task = Task::find($id);
    
    if ($task) {
        $task->delete();
        return redirect()->route('home')->with('success', 'Task deleted successfully.');
    }

    return redirect()->route('home')->with('error', 'Task not found.');
}


/**
 * Undocumented function
 *
 * @param Request $request
 * @return void
 */
    public function updateSortOrder(Request $request)
    {
        if ($request->input('sortorder')) {
            foreach($request->input('sortorder') as $id => $priority){
                Task::where('id', $id)->update(['priority' => $priority]);
            }
            return response()->json([
                'status' => 'success',
                'msg' => 'Task Sorted successfully'
            ]);
        }
        return response()->json([
            'status' => 'error',
            'msg' => 'Something went wrong!'
        ]);        

    } 
}
