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
  public function getProjectLevels(Request $request){
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
 *  Display a list of the structure levels.
 *  @param  \Illuminate\Http\Request  $request
 *  @return \Illuminate\Http\Response
 */
 public function getListOfProjectLevels(Request $request)
 {
    $listOfLevels = array();
    $levels = ProjectStructure::where('project_id', $request->id)->first();
 		$LevelsObjet = json_decode($levels->levels,true);
 		$this->getListOfLevels($LevelsObjet,$listOfLevels);
 		return ($listOfLevels);
  }

/**
  * Display a list of the structure levels.
  *
  * @param objet $LevelsObjet
  * @param array $listOfLevels
  * @return array $listOfLevels
  */
 	function getListOfLevels($LevelsObjet,&$listOfLevels)
 	{
 		if(isset($LevelsObjet['name']) ){
 		   array_push($listOfLevels,$LevelsObjet['name']);
 		}
 		if(isset($LevelsObjet['children']) and !empty($LevelsObjet['children']) ){
 		 	for ( $i = 0; $i< count($LevelsObjet['children']); $i++){
 				$this->getListOfLevels($LevelsObjet['children'][$i],$listOfLevels);
 	   	}
 		}
 	}

  /**
   *  Display a list of the all user functions registered in every level structure.
   *  @param  \Illuminate\Http\Request  $request
   *  @return \Illuminate\Http\Response
   */
   public function getListOfUserFunctions(Request $request)
   {
      $listOfUserFunctions = array();
      $levels = ProjectStructure::where('project_id', $request->id)->first();
      $LevelsObjet = json_decode($levels->levels,true);
      $this->getUserFunctionsR($LevelsObjet,$listOfUserFunctions);
      return ($listOfUserFunctions);
    }

  /**
    * Display a list of the userfunctions.
    *
    * @param objet $LevelsObjet
    * @param array $listOfLevels
    * @return array $listOfLevels
    */
    function getUserFunctionsR($LevelsObjet,&$listOfUserFunctions)
    {
      if(isset($LevelsObjet['userFunctions']) and !empty($LevelsObjet['userFunctions'])) {
        for ( $i = 0; $i< count($LevelsObjet['userFunctions']); $i++){
          array_push($listOfUserFunctions, array($LevelsObjet['userFunctions'][$i]['name'],$LevelsObjet['userFunctions'][$i]['users'],$LevelsObjet['name']));
         }
      }
      if(isset($LevelsObjet['children']) and !empty($LevelsObjet['children']) ){
        for ( $i = 0; $i< count($LevelsObjet['children']); $i++){
          $this->getUserFunctionsR($LevelsObjet['children'][$i],$listOfUserFunctions);
        }
      }
    }
}
