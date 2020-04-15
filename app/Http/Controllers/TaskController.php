<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $tasks = Task::latest()->paginate(5);
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
