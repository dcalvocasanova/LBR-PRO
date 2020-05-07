<?php

namespace App\Http\Controllers;

use App\TaskDetail;
use Illuminate\Http\Request;

class TaskDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $taskDetails = TaskDetail::where('project_id',$request->id)->latest()->paginate(5);
      return $taskDetails;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $taskDetails = TaskDetail::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $taskDetails = TaskDetail::findOrFail($request->id);
      return $taskDetails;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TaskDetail  $taskDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $taskDetails = TaskDetail::findOrFail($request->id);
      $taskDetails->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
          $taskDetails = TaskDetail::destroy($request->id);
    }
}
