<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Measure; 
use App\RelatedGoals;
use App\ExtendWorkday;
use App\SettingsMeasure;
use App\Imports\TaskMeasureImport;
use App\Http\Controllers\UserController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\MeasureRequest;
use Maatwebsite\Excel\Facades\Excel;

class MeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $measures = Measure::where('project_id',$request->id)->latest()->paginate(10);
      return $measures;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserMeasures()
    {
      $userMeasures = Measure::where('user_id', Auth::user()->id)->get();
      $categorias = collect();
      foreach ($userMeasures as $measure) {
        $categorias->push(array('value'=>$measure->measure,'name'=>"Tarea ".$measure->measure));
      }
      return $categorias;
    }
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserMeasuresTime()
    {
      $now = Carbon::now()->format('Y-m-d');
      $userMeasures = Measure::where('user_id', Auth::user()->id)->where('fecha', $now)->get();
      $categorias = collect();
	  $sumaTareas = 0;
      foreach ($userMeasures as $measure) {
       // $categorias->push(array('value'=>$measure->measure,'name'=>"Tarea ".$measure->measure));
		  
		  $sumaTareas += $measure->measure;
      }
      return $sumaTareas;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMeasureAccordingTypeAndLevel(Request $request)
    {
      if(isset($request->allocator)){
        $measures = Measure::where('project_id',$request->id)
                      ->where('allocator',$request->allocator)
                      ->latest()->paginate(10);
        return $measures;
      }
      if(isset($request->type) && isset($request->level)){
        $measures = Measure::where('project_id',$request->id)
                      ->where('type',$request->type)
                      ->where('relatedToLevel',$request->level)
                      ->latest()->paginate(10);
        return $measures;
      }
      if(isset($request->type)){
        $measures = Measure::where('project_id',$request->id)
                      ->where('type',$request->type)
                      ->latest()->paginate(10);
        return $measures;
      }
      if(isset($request->level)){
        $measures = Measure::where('project_id',$request->id)
                      ->where('relatedToLevel',$request->level)
                      ->latest()->paginate(10);
        return $measures;
      }
      $measures = Measure::where('project_id',$request->id)->latest()->paginate(10);
      return $measures;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MeasureRequest
     * @return \Illuminate\Http\Response
     */
    public function store(MeasureRequest $request)
    {
        $Measure = Measure::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $Measure = Measure::findOrFail($request->id);
      return $Measure;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MeasureRequest
     * @return \Illuminate\Http\Response
     */
    public function update(MeasureRequest $request)
    {
      $now = Carbon::now()->format('Y-m-d');

	  $Measure = Measure::firstOrNew(['user_id' =>$request->user_id,'task_id' => $request->task_id,'fecha' =>$now ]);

	  $Measure->project_id = $request->project_id;
	  $Measure->user_id = $request->user_id;//$this->User->getCurrentUser();
	  $Measure->task_id = $request->task_id;
	  $Measure->measure = $request->measure;
	  $Measure->fecha     = $now;
      $Measure->save();
    }
	
	public function ExtendWorkday(MeasureRequest $request)
    {
      
     $ExtendWorkday = ExtendWorkday::firstOrNew(['user' =>$request->user,'project_id' => $request->project_id,'project_id' => $request->fecha]);

	  $ExtendWorkday->project_id = $request->project_id;
	  $ExtendWorkday->user = $request->user;//$this->User->getCurrentUser();
	  $ExtendWorkday->extend = $request->extend;
	  $ExtendWorkday->relatedToLevel = $request->relatedToLevel;
	   $ExtendWorkday->fecha = $request->fecha;
      $ExtendWorkday->save();
    }
	
	/**
     * Update the specified resource in storage.
     *
     * @param  MeasureRequest
     * @return \Illuminate\Http\Response
     */
    public function updateSettings(MeasureRequest $request)
    {

	  $SettingsMeasure = SettingsMeasure::firstOrNew(['project_id' =>$request->project_id]);
	  $SettingsMeasure ->project_id = $request->project_id;
	  $SettingsMeasure->vacation = $request->vacation;
	  $SettingsMeasure->disability = $request->disability;
	  $SettingsMeasure->workdays = $request->workdays;
	  $SettingsMeasure->weekdays = $request->weekdays;
	  $SettingsMeasure->yeardays = $request->yeardays;
	  $SettingsMeasure->training = $request->training;
	  $SettingsMeasure->license = $request->license;
	  $SettingsMeasure->startProject = $request->startProject;
	  $SettingsMeasure->endProject = $request->endProject;
      $SettingsMeasure->save();
    }
	
	 public function getSettings(Request $request)
    {
		 
		 $SettingsMeasure = SettingsMeasure::Where('project_id', $request->id)->first();
		 return $SettingsMeasure;
	}
	
	public function getRelatedGoals(Request $request)
    {
		 
		 	 $RelatedGoals = RelatedGoals::select('currentGoals')
				 ->where('project_id', $request->project_id)
				 ->where('relatedLevel', $request->relatedLevel)
				 ->where('parentGoal', $request->parentGoal)->first();
		
		 return $RelatedGoals;
	}
	
	public function getExtendWorkday(Request $request)
    {
		$now = Carbon::now()->format('Y-m-d');
		$RelatedGoals = ExtendWorkday::select('extend')
				 ->where('project_id', $request->project_id)
				 ->where('user', Auth::user()->id)
				 ->where('fecha', $now)->first();
		
		 		return $RelatedGoals;
			 
	}
    /**
     * Change status as Read.
     *
     * @param  MeasureRequest
     * @return \Illuminate\Http\Response
     */
    public function changeMeasureStatus(Request $request)
    {
      $readAt = Carbon::now();
      $measures = Measure::find($request->measures);
      foreach ($measures as $measure) {
         $measure->notified ='true';
         $measure->send_at =$readAt;
         $measure->save();
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
        $Measure = Measure::destroy($request->id);
    }
	public function importTaskMeasures(Request $request)
    {
		 
   		 $data = Excel::toArray(new TaskMeasureImport, request()->file('archivo')); 
		
   		 return collect(head($data)) 
    		    ->each(function ($row, $key) use($request) {
			$now = Carbon::now()->format('Y-m-d');
            $Measure = Measure::firstOrNew(['user_id' =>$request->user_id,'task_id' =>  $row[0],'fecha' =>$now ]);

                //->update(array_except($row, ['id']));
					
				$Measure->project_id =  session('currentProject_id');
	            $Measure->user_id = Auth::user()->id;//$this->User->getCurrentUser();
	            $Measure->task_id = $row[0];
	            $Measure->measure = $row[2];
	            $Measure->fecha   = $now;
                $Measure->save();
        });
     }
}  

	  
