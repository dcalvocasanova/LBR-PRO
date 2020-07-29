<?php

namespace App\Http\Controllers;

use App\Task;
use App\UserTask;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

  public function getFrecuencyMeasuresByProduct(Request $request)
  {
    $result = array();
    $task = Task::select('frecuency', 'task')->where('project_id',$request->project_id)->where('type',$request->product)->get();
    $counter =  $task->countBy(function ($item) {
      return $item->frecuency;
    });
    $datos = collect();
    $legend = collect();
    foreach ($counter as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['task'] =$task;
    return $result;
  }

  public function getFrecuencyMeasuresByLevel(Request $request) {
    $result = array();
    $task = Task::select('frecuency')->where('project_id',$request->project_id)->where('relatedToLevel',$request->level)->get();
    $counter =  $task->countBy(function ($item) {
      return $item->frecuency;
    });
    $datos = collect();
    $legend = collect();
    foreach ($counter as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    return $result;
  }

  public function getFrecuencyMeasuresByFrecuency(Request $request) {
    $result = array();
    $task = Task::select('task')->where('project_id',$request->project_id)->where('frecuency',$request->frecuency)->get();
    $counter =  $task->countBy(function ($item) {
      return $item->task;
    });
    $datos = collect();
    $legend = collect();
    foreach ($counter as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    return $result;
  }
  public function getFrecuencyMeasuresByUser(Request $request) {
    $result = array();
    $userTasks =  UserTask::find($request->user_id);
    $task = Task::find($userTasks);
    $counter =  $task->countBy(function ($item) {
      return $item->frecuency;
    });
    $datos = collect();
    $legend = collect();
    foreach ($counter as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    return $result;
  }





  public function getUserMeasures()
  {
    $userMeasures = Measure::where('user_id', Auth::user()->id)->get();
    $categorias = collect();
    foreach ($userMeasures as $measure) {
      $categorias->push(array('value'=>$measure->measure,'name'=>"Tarea ".$measure->measure));
    }
    return $categorias;
  }
}
