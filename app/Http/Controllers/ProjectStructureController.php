<?php

namespace App\Http\Controllers;

use App\ProjectStructure;
use Illuminate\Http\Request;

class ProjectStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProjectLevels(Request $request)
    {
      $levels = ProjectStructure::where('project_id', $request->id)->paginate(10);
      return $levels;
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
            'nombre' => 'required|string|max:20',
            'nivel' => 'required|string|max:50'
      ]);
      $level = new ProjectStructure();
      $level->name = $request->nombre;
      $level->project_id = $request->proyecto;
      $level->level = isset($request->nivel)? $request->nivel:"0";
      $level->description = isset($request->descripcion)? $request->descripcion:"Nivel de ". $request->name;
      $level->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $level = ProjectStructure::findOrFail($request->id);
      return $level;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProjectStructure  $levelstructure
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectStructure $levelstructure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProjectStructure  $levelstructure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $this->validate($request,[
            'nombre' => 'required|string|max:20',
            'nivel' => 'required|string|max:50'

      ]);
      $level = ProjectStructure::findOrFail($request->id);
      $level->name = $request->nombre;
      $level->level = $request->nivel;
      $level->description = $request->descripcion;
      $level->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProjectStructure  $levelstructure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $level= ProjectStructure::destroy($request->id);
      return $level;
    }
}
