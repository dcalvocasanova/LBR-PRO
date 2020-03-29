<?php
namespace App\Http\Controllers;
use App\ProjectStructure;
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
	  
		return ($levels);
    }
	
	//obtiene el nombre de los macroprocesos
	public function getMacroprocessProject(Request $request)
    {
        $levels = ProjectStructure::where('project_id', $request->id)->first();
		$obj = json_decode($levels->levels,true);
		$macroprocesos = array();
		$this->hasChildren($obj,$macroprocesos);
		return ($macroprocesos);
		//return $obj['children'][0]['macroprocess'][0]['name'];
    }
	
	//funci'on recursiva para recuperar los macroprocesos
	function hasChildren($children,&$macroprocesos)
	{
		if(isset($children['macroprocess']) and !empty($children['macroprocess']) ){
		 		for ( $i = 0; $i< count($children['macroprocess']); $i++){
					array_push($macroprocesos,$children['macroprocess'][$i]['name']);
				 }
			}
		
		if(isset($children['children']) and !empty($children['children']) ){
		 	for ( $i = 0; $i< count($children['children']); $i++){
				$this->hasChildren($children['children'][$i],$macroprocesos);
	   		 }
		}
		
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
