<?php

namespace App\Http\Controllers;

use App\Task;
use App\UserTask;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $tasks = Task::where('project_id',$request->id)->latest()->paginate(10);
      return $tasks;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserTasks(Request $request)
    {
      $userTasks = UserTask::where('user_id',$request->id)->first();
	  $tasks = Task::find($userTasks->tasks_id)->paginate(10);
      return $tasks;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTaskAccordingTypeAndLevel(Request $request)
    {
      if(isset($request->allocator)){
        $tasks = Task::where('project_id',$request->id)
                      ->where('allocator',$request->allocator)
                      ->latest()->paginate(10);
        return $tasks;
      }
      if(isset($request->type) && isset($request->level)){
        $tasks = Task::where('project_id',$request->id)
                      ->where('type',$request->type)
                      ->where('relatedToLevel',$request->level)
                      ->latest()->paginate(10);
        return $tasks;
      }
      if(isset($request->type)){
        $tasks = Task::where('project_id',$request->id)
                      ->where('type',$request->type)
                      ->latest()->paginate(10);
        return $tasks;
      }
      if(isset($request->level)){
        $tasks = Task::where('project_id',$request->id)
                      ->where('relatedToLevel',$request->level)
                      ->latest()->paginate(10);
        return $tasks;
      }
      $tasks = Task::where('project_id',$request->id)->latest()->paginate(10);
      return $tasks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TaskRequest
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $Task = Task::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $Task = Task::findOrFail($request->id);
      return $Task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TaskRequest
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request)
    {
      $Task = Task::findOrFail($request->id);
      $Task->update($request->all());
    }

    /**
     * Change status as Read.
     *
     * @param  TaskRequest
     * @return \Illuminate\Http\Response
     */
    public function changeTaskStatus(Request $request)
    {
      $readAt = Carbon::now();
      $tasks = Task::find($request->tasks);
      foreach ($tasks as $task) {
         $task->notified ='true';
         $task->send_at =$readAt;
         $task->save();
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $Task = Task::destroy($request->id);
    }
}
