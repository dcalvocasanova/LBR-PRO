<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Measure;
use App\Http\Controllers\UserController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\MeasureRequest;

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
}
