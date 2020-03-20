<?php
namespace App\Http\Controllers;
use App\Function;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StructureProjectRequest;
use Illuminate\Support\Facades\DB;

class ProjectStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProjectLevels(Request $request)
    {
      $levels = ProjectStructure::where('project_id', $request->id)->first();
      return $levels;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StructureProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StructureProjectRequest $request)
    {
      $level = ProjectStructure::create($request->all());
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
     * Update the specified resource in storage.
     *
     * @param  StructureProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(StructureProjectRequest $request)
    {
      $level = ProjectStructure::findOrFail($request->id);
      $level->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     *  @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $levels = ProjectStructure::where('project_id', $request->id)->first();
      $levels->delete();
      return $levels;
    }

    /**
     * Display a listing of the structure levels.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListOfProjectLevels(Request $request)
    {
      $project = ProjectStructure::where('project_id', $request->id)->first();
      $levels = json_decode($project->levels);
      return $levels->children;
    }
}
