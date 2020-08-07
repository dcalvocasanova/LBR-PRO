<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\Catalog;
use App\UserTask;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

  /***** FRECUENCIAS ***/
  public function getFrecuencyMeasuresByProduct(Request $request){
    $result = array();
    $task = Task::select('frecuency', 'task')->where('project_id',$request->project_id)->where('type',$request->product)->get();
    $counter =  $task->countBy(function ($item) {
      return $item->frecuency;
    });
    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
      $graph_two->push(array('name'=>$key, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
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
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
      $graph_two->push(array('name'=>$key, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
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
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
      $graph_two->push(array('name'=>$key, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
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
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
      $graph_two->push(array('name'=>$key, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
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


  /******PHVA ***/
  public function getPHVAMeasuresByProduct(Request $request){
    $result = array();
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.PHVA')
                ->where('tasks.project_id',$request->project_id)
                ->where('tasks.type',$request->product)
                ->whereNotNull('PHVA')
                ->select('tasks.PHVA', 'catalogs.type')->get();
    $counter =  $task->countBy(function ($item) {
      if (!empty($item->type)){ return $item->type;}
      return $item->PHVA;
    });

    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $name='';
      if($key =="P"){$name="Planear";}
      if($key =="H"){$name="Hacer";}
      if($key =="V"){$name="Verificar";}
      if($key =="A"){$name="Actuar";}
      $datos->push(array('value'=>$value,'name'=> $name));
      $legend->push($name);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getPHVAMeasuresByLevel(Request $request) {
    $result = array();
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.PHVA')
                ->where('tasks.project_id',$request->project_id)
                ->where('tasks.relatedToLevel',$request->level)
                ->whereNotNull('relatedToLevel')
                ->select('tasks.PHVA', 'catalogs.type')->get();
    $counter =  $task->countBy(function ($item) {
      if (!empty($item->type)){ return $item->type;}
      return $item->PHVA;
    });
    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $name='';
      if($key =="P"){$name="Planear";}
      if($key =="H"){$name="Hacer";}
      if($key =="V"){$name="Verificar";}
      if($key =="A"){$name="Actuar";}
      $datos->push(array('value'=>$value,'name'=> $name));
      $legend->push($name);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getPHVAMeasuresByPHVA(Request $request) {
    $result = array();
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.PHVA')
                ->where('tasks.project_id',$request->project_id)
                ->where('tasks.PHVA',$request->phva)
                ->select('tasks.PHVA', 'catalogs.type')->get();

    $counter =  $task->countBy(function ($item) {
      if (!empty($item->type)){ return $item->type;}
      return $item->PHVA;
    });
    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $name='';
      if($key =="P"){$name="Planear";}
      if($key =="H"){$name="Hacer";}
      if($key =="V"){$name="Verificar";}
      if($key =="A"){$name="Actuar";}
      $datos->push(array('value'=>$value,'name'=> $name));
      $legend->push($name);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getPHVAMeasuresByUser(Request $request) {
    $result = array();
    $userTask=UserTask::where('user_id',$request->user_id)->get();
    $taskbyUser=explode(',', $userTask[0]->tasks_id);
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.PHVA')
                ->whereIn('tasks.id',$taskbyUser)
                ->whereNotNull('PHVA')
                ->select('tasks.PHVA', 'catalogs.type')->get();

    $counter =  $task->countBy(function ($item) {
      if (!empty($item->type)){ return $item->type;}
      return $item->PHVA;
    });

    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $name='';
      if($key =="P"){$name="Planear";}
      if($key =="H"){$name="Hacer";}
      if($key =="V"){$name="Verificar";}
      if($key =="A"){$name="Actuar";}
      $datos->push(array('value'=>$value,'name'=> $name));
      $legend->push($name);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getPHVAData(Request $request){
    $project = $request->project_id;

    $tasks= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.PHVA')
                ->where('tasks.project_id',$request->project_id)
                ->whereNotNull('PHVA')
                ->select('tasks.id','tasks.PHVA', 'tasks.relatedToLevel','tasks.allocator','tasks.PHVA','catalogs.type')->get();

    $users =  DB::table('user_tasks')
              ->Join('users', function ($join) use($project) {
                  $join->on('users.id', '=', 'user_tasks.user_id')
                  ->where('users.relatedProjects', '=', $project);
              })->select('users.name', 'users.identification', 'user_tasks.tasks_id')->get();

    $result = collect();
    foreach ($users as $user) {
        $taskAssigned=explode(',', $user->tasks_id);
        foreach ($taskAssigned as $taskReview) {
          $t =$tasks->where('id', $taskReview)->flatten();
          $phva =$t[0]['PHVA'];
          if (!empty($t[0]['type'])){ $phva =$t[0]['type'];}
          if($phva =="P"){$phva="Planear";}
          if($phva =="H"){$phva="Hacer";}
          if($phva =="V"){$phva="Verificar";}
          if($phva =="A"){$phva="Actuar";}
          $result->push(array('identification'=>$user->identification,
                         'user'=>$user->name,
                         'task'=>$t[0]['task'],
                         'level'=>$t[0]['relatedToLevel'],
                         'product'=>$t[0]['allocator'],
                         'PHVA'=>$phva,
                        ));
          }
    }
    $title =[
      ['label'=>"Identificación",'field'=> "identification",'numeric'=> false, 'html'=> false],
      ['label'=> "Nombre",'field'=> "user",'numeric'=> false, 'html'=> false],
      ['label'=> "Tarea",'field'=> "task",'numeric'=> false, 'html'=> false],
      ['label'=> "Nivel de estructura",'field'=> "level",'numeric'=> false, 'html'=> false],
      ['label'=> "Producto",'field'=> "product",'numeric'=> false, 'html'=> false],
      ['label'=> "PHVA",'field'=> "PHVA",'numeric'=> false, 'html'=> false]
    ];
    return ['content'=> $result, 'title'=> $title];
  }


  /******COMPETENCIAS ***/
  public function getCompentencesMeasuresByProduct(Request $request){
    $result = array();
    $competence = Task::select('competence', 'task')->where('project_id',$request->project_id)->where('type',$request->product)->get();
    $counter =  $competence->countBy(function ($item) {
      return $item->competence;
    });
    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
      $graph_two->push(array('name'=>$key, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getCompentencesMeasuresByLevel(Request $request) {
    $result = array();
    $task = Task::select('competence')->where('project_id',$request->project_id)->where('relatedToLevel',$request->level)->get();
    $counter =  $task->countBy(function ($item) {
      return $item->competence;
    });
    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
      $graph_two->push(array('name'=>$key, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function geCompentencesAMeasuresByCompetence(Request $request) {
    $result = array();
    $task = Task::select('competence')->where('project_id',$request->project_id)->where('competence',$request->competence)->get();
    $counter =  $task->countBy(function ($item) {
      return $item->competence;
    });
    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
      $graph_two->push(array('name'=>$key, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getCompentencesMeasuresByUser(Request $request) {
    $result = array();
    $userTask=UserTask::where('user_id',$request->user_id)->get();
    $taskbyUser=explode(',', $userTask[0]->tasks_id);
    $task = Task::find($taskbyUser);
    $counter =  $task->countBy(function ($item) {
      return $item->competence;
    });
    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
      $graph_two->push(array('name'=>$key, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getCompentencesData(Request $request){
    $project = $request->project_id;
    $tasks= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.competence')
                ->where('tasks.project_id',$request->project_id)
                ->whereNotNull('competence')
                ->select('tasks.id','tasks.PHVA', 'tasks.relatedToLevel','tasks.allocator','tasks.competence','catalogs.type')->get();

    return $tasks;
  //  $tasks = Task::select('id','task','relatedToLevel','allocator','competence')->where('project_id',$project)->get();
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
                         'competence'=>$t[0]['competence'],
                        ));
        }
    }
    $title =[
      ['label'=>"Identificación",'field'=> "identification",'numeric'=> false, 'html'=> false],
      ['label'=> "Nombre",'field'=> "user",'numeric'=> false, 'html'=> false],
      ['label'=> "Tarea",'field'=> "task",'numeric'=> false, 'html'=> false],
      ['label'=> "Nivel de estructura",'field'=> "level",'numeric'=> false, 'html'=> false],
      ['label'=> "Producto",'field'=> "product",'numeric'=> false, 'html'=> false],
      ['label'=> "Competencia",'field'=> "competence",'numeric'=> false, 'html'=> false]
    ];
    return ['content'=> $result, 'title'=> $title];
  }

  /*****  ***/

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
