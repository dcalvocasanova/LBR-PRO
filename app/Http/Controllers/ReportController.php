<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\UserTask;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

  public function getFrecuencyMeasuresByProduct(Request $request){
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
    $userTask=UserTask::where('user_id',$request->user_id)->get();
    $taskbyUser=explode(',', $userTask[0]->tasks_id);
    $task = Task::find($taskbyUser);
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

  public function getFrecuencyData(Request $request){
    $project = $request->project_id;
    $tasks = Task::select('id','task','relatedToLevel','allocator','frecuency')->where('project_id',$project)->get();
    $users =  DB::table('user_tasks')
              ->Join('users', function ($join) use($project) {
                  $join->on('users.id', '=', 'user_tasks.user_id')
                  ->where('users.relatedProjects', '=', $project);
              })->select('users.name', 'users.identification', 'user_tasks.tasks_id')->get();

    $result = collect();
    foreach ($users as $user) {
        $taskAssigned=explode(',', $user->tasks_id);
        foreach ($taskAssigned as $task) {
          $t =$tasks->where('id', $task)->flatten();
          $result->push(array('identification'=>$user->identification,
                         'user'=>$user->name,
                         'task'=>$t[0]['task'],
                         'level'=>$t[0]['relatedToLevel'],
                         'product'=>$t[0]['allocator'],
                         'frecuency'=>$t[0]['frecuency'],
                        ));
        }
    }
    $title =[
      ['label'=>"Identificación",'field'=> "identification",'numeric'=> false, 'html'=> false],
      ['label'=> "Nombre",'field'=> "user",'numeric'=> false, 'html'=> false],
      ['label'=> "Tarea",'field'=> "task",'numeric'=> false, 'html'=> false],
      ['label'=> "Nivel de estructura",'field'=> "level",'numeric'=> false, 'html'=> false],
      ['label'=> "Producto",'field'=> "product",'numeric'=> false, 'html'=> false],
      ['label'=> "Frecuencia",'field'=> "frecuency",'numeric'=> false, 'html'=> false]
    ];
    return ['content'=> $result, 'title'=> $title];
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


  public function getUserParameterMeasures(Request $request)
  {

    $result = array();
    $userParameterMeasures = collect();
    $userParameterMeasures = ParametersMeasure::where('user_id', Auth::user()->id)->get();

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
  }
}
