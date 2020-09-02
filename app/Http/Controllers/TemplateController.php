<?php
namespace App\Http\Controllers;
use App\Template;
use App\Criteria;
use App\ParametersMeasure;
use Illuminate\Support\Facades\Auth;
use App\TemplateUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TemplateRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $templates = Template::latest()->paginate(5);
      return $templates;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TemplateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TemplateRequest $request)
    {
      $template = Template::create($request->all());
    }
	
	public function relateToUsers(Request $request)
    {
     // $template = TemplateUsers::create($request->all());
		
	  $TemplateUsers = TemplateUsers::firstOrNew(['relatedToLevel' =>$request->relatedToLevel,'project_id' => $request->project_id,'relatedTemplate' => $request->relatedTemplate]);

	  $TemplateUsers->project_id = $request->project_id;
	  $TemplateUsers->RelatedUsers = $request->usersToRelate;//$this->User->getCurrentUser();
	  $TemplateUsers->relatedToLevel = $request->relatedToLevel;
	  $TemplateUsers->relatedTemplate = $request->relatedTemplate;
      $TemplateUsers->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show (Request $request)
    {
      $template = Template::findOrFail($request->id);
      return $template;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TemplateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(TemplateRequest $request)
    {
      $template = Template::findOrFail($request->id);
      $template->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
      $template = Template::destroy($request->id);
    }

    /**
     * Get all variables according to a type
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTemplatesByType(Request $request)
    {
      $template = Template::where('type',$request->type)->latest()->paginate(5);
      return $template;
    }
	
	public function getUsersByTemplate(Request $request){
		$users = TemplateUsers::select('RelatedUsers')->where('project_id', $request->project)
			->where('relatedToLevel', $request->level)
			->where('relatedTemplate', $request->template)
			->first();
			return $users;
		
	}
	
	public function getTemplatesByUser(Request $request)
    {
		
		$usersTemplates =[];
	  $user = TemplateUsers::select('relatedTemplate')->where('relatedUsers','like', '%'.Auth::user()->id.'%')->get();
	  
	  foreach($user as $template)
		array_push($usersTemplates,$template['relatedTemplate']);
			
	  $template = Template::where('type',$request->type)->wherein('id',$usersTemplates)->first();
	
	  //return $template;
	  $obj = json_decode($template->stencil,true);
	  $idCriterio = $template->description;
	  $catalogos = array();
	  $categorias = array();
	  $collection = collect();
	  //return $obj;
	    
	  for ( $i = 1; $i< count($obj)+1; $i++){
		  $now = Carbon::now()->format('Y-m-d');
		  
		  //return $obj[$i]['question'];
		  
		  
		  if($request->type == 'workload'){
			     $measure = ParametersMeasure::select('measure')->where('user_id',Auth::user()->id)
						 ->where('variable',$obj[$i]['name'])
						 ->where('fecha',$now)->first();

			  if($measure){
				  $measure = (Int)$measure->measure;
			  }else{$measure = 10;}
		  
		  
			$category = $obj[$i]['category']; 
			array_push($categorias, $category); 
			$collection->push( ["category" =>$category, "id" =>$obj[$i]['id'] ,"variable"=>$obj[$i]['name'] , "measure" =>$measure]);
			  
		 }elseif($request->type == 'psychosocial'){
			  
			  $criterio = Criteria::select('categories')->where('id',$idCriterio)->first();
			 $criterio= json_decode($criterio->categories,true);
			  if($measure = ParametersMeasure::select('measure')->where('user_id',Auth::user()->id)->where('variable',$obj[$i]['question'])->first()){
				  
				  //  return $measure;
				  $measure = $measure->measure;
			  }else{$measure = 0;}
			  
			  
			 $question = $obj[$i]['question']; 
			//array_push($categorias, $category); 
		 $collection->push( ["category" =>'preguntas',"id" =>$obj[$i]['id'] ,"variable"=>$obj[$i]['question'] , "measure" =>$measure,"criterio" =>$criterio]);
		 }
	  }
		
	 $collection = $collection->groupBy('category');
	// $collection = $collection->values();
	//$collection = $collection->groupBy('category');
	  
	return ($collection);
		
    }
	

}
