<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $projects = Project::all();
      return $projects;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,[
            'name' => 'required|string|max:191'
      ]);
      $project = new Project();
      $project->name = $request->name;
      $project->logo_project = $request->logo_project;
      $project->logo_sponsor = $request->logo_sponsor;
      $project->logo_auxiliar = $request->logo_auxiliar;
      $project->description = $request->description;
      $project->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $project = Project::findOrFail($request->id);
      return $project;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $project = Project::findOrFail($request->id);

      $project->name = $request->name;
      $project->logo_project = $request->logo_project;
      $project->logo_sponsor = $request->logo_sponsor;
      $project->logo_auxiliar = $request->logo_auxiliar;
      $project->description = $request->description;

      $project->save();

      return $project;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
      $project = Project::destroy($request->id);
      return $project;
    }
}
