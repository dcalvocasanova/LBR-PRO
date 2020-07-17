<?php

namespace App\Http\Controllers;

use App\ParametersMeasure;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ParameterMeasureRequest;

class ParameterMeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $measures = ParameterMeasure::where('project_id',$request->id)->latest()->paginate(10);
      return $measures;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserParameterMeasures(Request $request)
    {
      //$userMeasures = Measure::where('user_id', Auth::user()->id)->get();
      $result = array();
      $userParameterMeasures = collect();
      $userParameterMeasures = ParametersMeasure::where('user_id', Auth::user()->id)->get();
      //$userParameterMeasures->groupBy('fecha');

      $result['Data'] = $userParameterMeasures->groupBy([
          'fecha',
          function ($item) {
              return $item['fecha'];
          },
      ], $preserveKeys = true);

      $result['Legend'] = $userParameterMeasures->unique('fecha')
                          ->map(function ($row) {return $row['fecha'];})->flatten();

      $result['Amount'] = $userParameterMeasures->groupBy('fecha')
                        ->map(function ($row) {return $row->sum('measure');})->flatten();
      return $result;

      /*foreach ($userParameterMeasures as $measure) {
        $categorias->push(array('value'=>$measure->measure,'name'=>"Tarea ".$measure->measure));
      }
      return $categorias;*/

    //  $userParameterMeasures = UserParameterMeasure::where('user_id',$request->user_id);
    //  return $userParameterMeasures;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getParameterMeasureAccordingTypeAndLevel(Request $request)
    {
      if(isset($request->allocator)){
        $measures = ParameterMeasure::where('project_id',$request->id)
                      ->where('allocator',$request->allocator)
                      ->latest()->paginate(10);
        return $measures;
      }
      if(isset($request->type) && isset($request->level)){
        $measures = ParameterMeasure::where('project_id',$request->id)
                      ->where('type',$request->type)
                      ->where('relatedToLevel',$request->level)
                      ->latest()->paginate(10);
        return $measures;
      }
      if(isset($request->type)){
        $measures = ParameterMeasure::where('project_id',$request->id)
                      ->where('type',$request->type)
                      ->latest()->paginate(10);
        return $measures;
      }
      if(isset($request->level)){
        $measures = ParameterMeasure::where('project_id',$request->id)
                      ->where('relatedToLevel',$request->level)
                      ->latest()->paginate(10);
        return $measures;
      }
      $measures = ParameterMeasure::where('project_id',$request->id)->latest()->paginate(10);
      return $measures;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ParameterMeasureRequest
     * @return \Illuminate\Http\Response
     */
    public function store(ParameterMeasureRequest $request)
    {
        $ParameterMeasure = ParameterMeasure::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $ParameterMeasure = ParameterMeasure::findOrFail($request->id);
      return $ParameterMeasure;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ParameterMeasureRequest
     * @return \Illuminate\Http\Response
     */
    public function update(ParameterMeasureRequest $request)
    {

	$now = Carbon::now()->format('Y-m-d');

      $ParameterMeasure = ParametersMeasure::firstOrNew(['user_id' =>$request->user_id,'category_id' => $request->category_id,'variable'       =>$request->variable,'fecha' =>$now ]);

	  $ParameterMeasure->project_id = $request->project_id;
	  $ParameterMeasure->user_id = $request->user_id;//$this->User->getCurrentUser();
	  $ParameterMeasure->category_id = $request->category_id;
	  $ParameterMeasure->measure = $request->measure;
	  $ParameterMeasure->variable = $request->variable;
	  $ParameterMeasure->fecha     = $now;
      $ParameterMeasure->save();
    }

    /**
     * Change status as Read.
     *
     * @param  ParameterMeasureRequest
     * @return \Illuminate\Http\Response
     */
    public function changeParameterMeasureStatus(Request $request)
    {
      $readAt = Carbon::now();
      $measures = ParameterMeasure::find($request->measures);
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
        $ParameterMeasure = ParameterMeasure::destroy($request->id);
    }
}
