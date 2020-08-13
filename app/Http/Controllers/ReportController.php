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


  /****** PHVA ***/
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
                ->select('tasks.task','tasks.PHVA', 'catalogs.type')->get();

    $datos = collect();
    $legend = collect();
    $graph_two = collect();

    foreach ($task as $t){
      $datos->push(array('value'=> 1 ,'name'=>$t->task));
      $legend->push($t->task);
      $graph_two->push(array('name'=>$t->task, 'type'=>'bar', 'stack'=> $t->type, 'data'=>array(1)));
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


  /****** COMPETENCIAS ***/
  public function getCompentencesMeasuresByProduct(Request $request){
    $result = array();
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.competence')
                ->where('tasks.project_id',$request->project_id)
                ->where('tasks.type',$request->product)
                ->whereNotNull('tasks.competence')
                ->select('tasks.competence', 'catalogs.type', 'catalogs.id', 'catalogs.name')->get();
    $counter =  $task->countBy(function ($item) {
      if (($item->type =="SKILL-T")){ return $item->id;}
      $id = explode("-T", $item->type);
      return $id[0];
    });

    $datos = collect();
    $legend = collect();
    $graph_two = collect();

    foreach ($counter as $key => $value){
      $name = Catalog::Where('id',$key)->get('name')[0]->name;
      $datos->push(array('value'=>$value,'name'=>$name));
      $legend->push($name);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getCompentencesMeasuresByLevel(Request $request) {
    $result = array();
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.competence')
                ->where('tasks.project_id',$request->project_id)
                ->where('tasks.relatedToLevel',$request->level)
                ->whereNotNull('tasks.competence')
                ->select('tasks.competence', 'catalogs.type', 'catalogs.id', 'catalogs.name')->get();
    $counter =  $task->countBy(function ($item) {
      if (($item->type =="SKILL-T")){ return $item->id;}
      $id = explode("-T", $item->type);
      return $id[0];
    });

    $datos = collect();
    $legend = collect();
    $graph_two = collect();

    foreach ($counter as $key => $value){
      $name = Catalog::Where('id',$key)->get('name')[0]->name;
      $datos->push(array('value'=>$value,'name'=>$name));
      $legend->push($name);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getCompentencesMeasuresByCompetence(Request $request) {
    $result = array();
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.competence')
                ->where('tasks.project_id',$request->project_id)
                ->where('tasks.competence',$request->competence)
                ->whereNotNull('tasks.competence')
                ->select('tasks.competence', 'catalogs.type', 'catalogs.id', 'tasks.task')->get();

    $datos = collect();
    $legend = collect();
    $graph_two = collect();

    foreach ($task as $t){
      $datos->push(array('value'=> 1 ,'name'=>$t->task));
      $legend->push($t->task);
      $graph_two->push(array('name'=>$t->task, 'type'=>'bar', 'stack'=> $t->type, 'data'=>array(1)));
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
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.competence')
                ->whereIn('tasks.id',$taskbyUser)
                ->whereNotNull('tasks.competence')
                ->select('tasks.competence', 'catalogs.type', 'catalogs.id', 'catalogs.name')->get();

    $counter =  $task->countBy(function ($item) {
      if (($item->type =="SKILL-T")){ return $item->id;}
      $id = explode("-T", $item->type);
      return $id[0];
    });

    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $name = Catalog::Where('id',$key)->get('name')[0]->name;
      $datos->push(array('value'=>$value,'name'=>$name));
      $legend->push($key);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
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
                ->whereNotNull('PHVA')
                ->select('tasks.id','tasks.competence', 'tasks.relatedToLevel','tasks.allocator','catalogs.type', 'catalogs.name')->get();

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
          $result->push(array('identification'=>$user->identification,
                         'user'=>$user->name,
                         'task'=>$t[0]['task'],
                         'level'=>$t[0]['relatedToLevel'],
                         'product'=>$t[0]['allocator'],
                         'competence'=>$t[0]['name'],
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

  /***** ESFUERZO ***/

  public function getEffortMeasuresByProduct(Request $request){
    $result = array();
    $task = Task::select('task')->where('project_id',$request->project_id)->where('type',$request->product)->get();
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

  public function getEffortMeasuresByLevel(Request $request) {
    $result = array();
    $task = Task::select('effort')->where('project_id',$request->project_id)->where('relatedToLevel',$request->level)->get();
    $counter =  $task->countBy(function ($item) {
      return $item->effort;
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

  public function getEffortMeasuresByEffort(Request $request) {
    $result = array();
    $task = Task::select('task','effort')->where('project_id',$request->project_id)->where('effort','"'.$request->effort.'"')->get();

    $datos = collect();
    $legend = collect();
    $graph_two = collect();

    foreach ($task as $t){
      $datos->push(array('value'=> 1 ,'name'=>$t->task));
      $legend->push($t->task);
      $graph_two->push(array('name'=>$t->task, 'type'=>'bar', 'stack'=> $t->type, 'data'=>array(1)));
    }

    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getEffortMeasuresByUser(Request $request) {
    $result = array();
    $userTask=UserTask::where('user_id',$request->user_id)->get();
    $taskbyUser=explode(',', $userTask[0]->tasks_id);
    $task = Task::find($taskbyUser);
    $counter =  $task->countBy(function ($item) {
      return $item->effort;
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

  public function getEffortData(Request $request){
    $project = $request->project_id;
    $tasks = Task::select('id','task','relatedToLevel','allocator','effort')->where('project_id',$project)->get();
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
                         'effort'=>$t[0]['effort'],
                        ));
        }
    }
    $title =[
      ['label'=>"Identificación",'field'=> "identification",'numeric'=> false, 'html'=> false],
      ['label'=> "Nombre",'field'=> "user",'numeric'=> false, 'html'=> false],
      ['label'=> "Tarea",'field'=> "task",'numeric'=> false, 'html'=> false],
      ['label'=> "Nivel de estructura",'field'=> "level",'numeric'=> false, 'html'=> false],
      ['label'=> "Producto",'field'=> "product",'numeric'=> false, 'html'=> false],
      ['label'=> "Esfuerzo",'field'=> "effort",'numeric'=> false, 'html'=> false]
    ];
    return ['content'=> $result, 'title'=> $title];
  }


  /***** TIPO DE TRABAJO ***/

  public function getWorkTypeMeasuresByProduct(Request $request){
    $result = array();
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.laborType')
                ->where('tasks.project_id',$request->project_id)
                ->where('tasks.type',$request->product)
                ->whereNotNull('tasks.laborType')
                ->select('tasks.laborType', 'catalogs.type', 'catalogs.id', 'catalogs.name')->get();
    $counter =  $task->countBy(function ($item) {
      if (($item->type =="WORKTYPE")){ return $item->id;}
      $id = explode("-T", $item->type);
      return $id[0];
    });

    $datos = collect();
    $legend = collect();
    $graph_two = collect();

    foreach ($counter as $key => $value){
      $name = Catalog::Where('id',$key)->get('name')[0]->name;
      $datos->push(array('value'=>$value,'name'=>$name));
      $legend->push($name);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getWorkTypeMeasuresByLevel(Request $request) {
    $result = array();
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.laborType')
                ->where('tasks.project_id',$request->project_id)
                ->where('tasks.relatedToLevel',$request->level)
                ->whereNotNull('tasks.laborType')
                ->select('tasks.laborType', 'catalogs.type', 'catalogs.id', 'catalogs.name')->get();
    $counter =  $task->countBy(function ($item) {
      if (($item->type =="WORKTYPE")){ return $item->id;}
      $id = explode("-T", $item->type);
      return $id[0];
    });

    $datos = collect();
    $legend = collect();
    $graph_two = collect();

    foreach ($counter as $key => $value){
      $name = Catalog::Where('id',$key)->get('name')[0]->name;
      $datos->push(array('value'=>$value,'name'=>$name));
      $legend->push($name);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getWorkTypeMeasuresByWorkType(Request $request) {
    $result = array();
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.laborType')
                ->where('tasks.project_id',$request->project_id)
                ->where('tasks.laborType',$request->workType)
                ->whereNotNull('tasks.laborType')
                ->select('tasks.laborType', 'catalogs.type', 'catalogs.id', 'tasks.task')->get();

    $datos = collect();
    $legend = collect();
    $graph_two = collect();

    foreach ($task as $t){
      $datos->push(array('value'=> 1 ,'name'=>$t->task));
      $legend->push($t->task);
      $graph_two->push(array('name'=>$t->task, 'type'=>'bar', 'stack'=> $t->type, 'data'=>array(1)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getWorkTypeMeasuresByUser(Request $request) {
    $result = array();
    $userTask=UserTask::where('user_id',$request->user_id)->get();
    $taskbyUser=explode(',', $userTask[0]->tasks_id);
    $task = Task::find($taskbyUser);
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.laborType')
                ->whereIn('tasks.id',$taskbyUser)
                ->whereNotNull('tasks.laborType')
                ->select('tasks.laborType', 'catalogs.type', 'catalogs.id', 'catalogs.name')->get();

    $counter =  $task->countBy(function ($item) {
      if (($item->type =="WORKTYPE")){ return $item->id;}
      $id = explode("-T", $item->type);
      return $id[0];
    });

    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $name = Catalog::Where('id',$key)->get('name')[0]->name;
      $datos->push(array('value'=>$value,'name'=>$name));
      $legend->push($key);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getWorkTypeData(Request $request){

    $project = $request->project_id;
    $tasks= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.laborType')
                ->where('tasks.project_id',$request->project_id)
                ->whereNotNull('PHVA')
                ->select('tasks.id','tasks.laborType', 'tasks.relatedToLevel','tasks.allocator','catalogs.type', 'catalogs.name')->get();

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
          $result->push(array('identification'=>$user->identification,
                         'user'=>$user->name,
                         'task'=>$t[0]['task'],
                         'level'=>$t[0]['relatedToLevel'],
                         'product'=>$t[0]['allocator'],
                         'laborType'=>$t[0]['name'],
                        ));
          }
    }
    $title =[
      ['label'=>"Identificación",'field'=> "identification",'numeric'=> false, 'html'=> false],
      ['label'=> "Nombre",'field'=> "user",'numeric'=> false, 'html'=> false],
      ['label'=> "Tarea",'field'=> "task",'numeric'=> false, 'html'=> false],
      ['label'=> "Nivel de estructura",'field'=> "level",'numeric'=> false, 'html'=> false],
      ['label'=> "Producto",'field'=> "product",'numeric'=> false, 'html'=> false],
      ['label'=> "Tipo de trabajo",'field'=> "laborType",'numeric'=> false, 'html'=> false]
    ];
    return ['content'=> $result, 'title'=> $title];
  }



  /***** Riesgos***/

  public function getRiskMeasuresByProduct(Request $request){
    $result = array();
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.risk')
                ->where('tasks.project_id',$request->project_id)
                ->where('tasks.type',$request->product)
                ->whereNotNull('tasks.risk')
                ->select('tasks.risk', 'catalogs.type', 'catalogs.id', 'catalogs.name')->get();

    $counter =  $task->countBy(function ($item) {
      if (($item->type =="RISK-T")){ return $item->id;}
      $id = explode("-T", $item->type);
      return $id[0];
    });

    $datos = collect();
    $legend = collect();
    $graph_two = collect();

    foreach ($counter as $key => $value){
      $name = Catalog::Where('id',$key)->get('name')[0]->name;
      $datos->push(array('value'=>$value,'name'=>$name));
      $legend->push($name);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getRiskMeasuresByLevel(Request $request) {
    $result = array();
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.risk')
                ->where('tasks.project_id',$request->project_id)
                ->where('tasks.relatedToLevel',$request->level)
                ->whereNotNull('tasks.risk')
                ->select('tasks.risk', 'catalogs.type', 'catalogs.id', 'catalogs.name')->get();
    $counter =  $task->countBy(function ($item) {
      if (($item->type =="RISK-T")){ return $item->id;}
      $id = explode("-T", $item->type);
      return $id[0];
    });

    $datos = collect();
    $legend = collect();
    $graph_two = collect();

    foreach ($counter as $key => $value){
      $name = Catalog::Where('id',$key)->get('name')[0]->name;
      $datos->push(array('value'=>$value,'name'=>$name));
      $legend->push($name);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getRiskMeasuresByRisk(Request $request) {
    $result = array();
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.risk')
                ->where('tasks.project_id',$request->project_id)
                ->where('tasks.risk',$request->risk)
                ->whereNotNull('tasks.risk')
                ->select('tasks.risk', 'catalogs.type', 'catalogs.id', 'tasks.task')->get();

    $datos = collect();
    $legend = collect();
    $graph_two = collect();

    foreach ($task as $t){
      $datos->push(array('value'=> 1 ,'name'=>$t->task));
      $legend->push($t->task);
      $graph_two->push(array('name'=>$t->task, 'type'=>'bar', 'stack'=> $t->type, 'data'=>array(1)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getRiskMeasuresByUser(Request $request) {
    $result = array();
    $userTask=UserTask::where('user_id',$request->user_id)->get();
    $taskbyUser=explode(',', $userTask[0]->tasks_id);
    $task = Task::find($taskbyUser);
    $task= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.risk')
                ->whereIn('tasks.id',$taskbyUser)
                ->whereNotNull('tasks.risk')
                ->select('tasks.risk', 'catalogs.type', 'catalogs.id', 'catalogs.name')->get();

    $counter =  $task->countBy(function ($item) {
      if (($item->type =="RISK-T")){ return $item->id;}
      $id = explode("-T", $item->type);
      return $id[0];
    });

    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $name = Catalog::Where('id',$key)->get('name')[0]->name;
      $datos->push(array('value'=>$value,'name'=>$name));
      $legend->push($key);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getRiskData(Request $request){

    $project = $request->project_id;
    $tasks= task::leftJoin('catalogs', 'catalogs.id', '=', 'tasks.risk')
                ->where('tasks.project_id',$request->project_id)
                ->whereNotNull('risk')
                ->select('tasks.id','tasks.risk', 'tasks.task', 'tasks.relatedToLevel','tasks.allocator','catalogs.type', 'catalogs.name')->get();

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
          $result->push(array('identification'=>$user->identification,
                         'user'=>$user->name,
                         'task'=>$t[0]['task'],
                         'level'=>$t[0]['relatedToLevel'],
                         'product'=>$t[0]['allocator'],
                         'risk'=>$t[0]['name'],
                        ));
          }
    }
    $title =[
      ['label'=>"Identificación",'field'=> "identification",'numeric'=> false, 'html'=> false],
      ['label'=> "Nombre",'field'=> "user",'numeric'=> false, 'html'=> false],
      ['label'=> "Tarea",'field'=> "task",'numeric'=> false, 'html'=> false],
      ['label'=> "Nivel de estructura",'field'=> "level",'numeric'=> false, 'html'=> false],
      ['label'=> "Producto",'field'=> "product",'numeric'=> false, 'html'=> false],
      ['label'=> "Riesgo",'field'=> "risk",'numeric'=> false, 'html'=> false]
    ];
    return ['content'=> $result, 'title'=> $title];
  }

  /***** VALOR AGREGADO***/

  public function getAddedValueMeasuresByProduct(Request $request){
    $result = array();
    $task = Task::select('addedValue', 'task')->where('project_id',$request->project_id)->where('type',$request->product)->whereNotNull('addedValue')->get();
    $counterAddedValueReal=0;
    $counterAddedValueEnterprice=0;
    $counterNoAddedValue=0;

    foreach ($task as $t) {
      if(isset($t->addedValue[0]) && isset($t->addedValue[1]) && isset($t->addedValue[2])){
        if($t->addedValue[0]== "4" || $t->addedValue[0] == "5"){
          $counterAddedValueReal ++;
        }elseif ($t->addedValue[1]== "4" || $t->addedValue[1] == "5" || $t->addedValue[2]== "4" || $t->addedValue[2] == "5")  {
          $counterAddedValueEnterprice ++;
        }else{
          $counterNoAddedValue ++;
        }
      }
    }

    $datos = collect();
    $legend = collect();
    $graph_two = collect();


    if($counterAddedValueReal > 0){
      $datos->push(array('value'=>$counterAddedValueReal,'name'=>'Valor real'));
      $legend->push('Valor real');
      $graph_two->push(array('name'=>'Valor real', 'type'=>'bar', 'stack'=> 'VR', 'data'=>array($counterAddedValueReal)));
    }
    if($counterAddedValueEnterprice > 0){
      $datos->push(array('value'=>$counterAddedValueEnterprice,'name'=>'Valor agregado para la empresa'));
      $legend->push('Valor agregado para la empresa');
      $graph_two->push(array('name'=>'Valor agregado para la empresa', 'type'=>'bar', 'stack'=> 'VRE', 'data'=>array($counterAddedValueEnterprice)));
    }
    if($counterNoAddedValue > 0){
      $datos->push(array('value'=>$counterNoAddedValue,'name'=>'Sin valor real'));
      $legend->push('Sin valor real');
      $graph_two->push(array('name'=>'Sin valor real', 'type'=>'bar', 'stack'=> 'NVR', 'data'=>array($counterNoAddedValue)));
    }

    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getAddedValueMeasuresByLevel(Request $request) {
    $result = array();
    $task = Task::select('addedValue')->where('project_id',$request->project_id)->where('relatedToLevel',$request->level)->get();
    $counterAddedValueReal=0;
    $counterAddedValueEnterprice=0;
    $counterNoAddedValue=0;

    foreach ($task as $t) {
      if(isset($t->addedValue[0]) && isset($t->addedValue[1]) && isset($t->addedValue[2])){
        if($t->addedValue[0]== "4" || $t->addedValue[0] == "5"){
          $counterAddedValueReal ++;
        }elseif ($t->addedValue[1]== "4" || $t->addedValue[1] == "5" || $t->addedValue[2]== "4" || $t->addedValue[2] == "5")  {
          $counterAddedValueEnterprice ++;
        }else{
          $counterNoAddedValue ++;
        }
      }
    }

    $datos = collect();
    $legend = collect();
    $graph_two = collect();


    if($counterAddedValueReal > 0){
      $datos->push(array('value'=>$counterAddedValueReal,'name'=>'Valor real'));
      $legend->push('Valor real');
      $graph_two->push(array('name'=>'Valor real', 'type'=>'bar', 'stack'=> 'VR', 'data'=>array($counterAddedValueReal)));
    }
    if($counterAddedValueEnterprice > 0){
      $datos->push(array('value'=>$counterAddedValueEnterprice,'name'=>'Valor agregado para la empresa'));
      $legend->push('Valor agregado para la empresa');
      $graph_two->push(array('name'=>'Valor agregado para la empresa', 'type'=>'bar', 'stack'=> 'VRE', 'data'=>array($counterAddedValueEnterprice)));
    }
    if($counterNoAddedValue > 0){
      $datos->push(array('value'=>$counterNoAddedValue,'name'=>'Sin valor real'));
      $legend->push('Sin valor real');
      $graph_two->push(array('name'=>'Sin valor real', 'type'=>'bar', 'stack'=> 'NVR', 'data'=>array($counterNoAddedValue)));
    }

    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getAddedValueMeasuresByAddedValue(Request $request) {
    $result = array();
    $option= $request->addedValue;

    $task = Task::select('addedValue', 'task')->where('project_id',$request->project_id)->get();
    $datos = collect();
    $legend = collect();
    $graph_two = collect();

    foreach ($task as $t) {
      if(isset($t->addedValue[0]) && isset($t->addedValue[1]) && isset($t->addedValue[2])){
        if($option == 1){
          if($t->addedValue[0]== "4" || $t->addedValue[0] == "5"){
            $datos->push(array('value'=> 1 ,'name'=>$t->task));
            $legend->push($t->task);
            $graph_two->push(array('name'=>$t->task, 'type'=>'bar', 'stack'=> 'VR', 'data'=>array(1)));
          }
        }
        if($option == 2){
            if($t->addedValue[1]== "4" || $t->addedValue[1] == "5" || $t->addedValue[2]== "4" || $t->addedValue[2] == "5"){
              $datos->push(array('value'=> 1 ,'name'=>$t->task));
              $legend->push($t->task);
              $graph_two->push(array('name'=>$t->task, 'type'=>'bar', 'stack'=> 'VR', 'data'=>array(1)));
            }
        }
        if($option == 3){
          if($t->addedValue[0] != "4" && $t->addedValue[0] != "5" && $t->addedValue[1] != "4" && $t->addedValue[1] != "5" && $t->addedValue[2] != "4" && $t->addedValue[2] != "5"){
            $datos->push(array('value'=> 1 ,'name'=>$t->task));
            $legend->push($t->task);
            $graph_two->push(array('name'=>$t->task, 'type'=>'bar', 'stack'=> 'VR', 'data'=>array(1)));
          }
        }
      }
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getAddedValueMeasuresByUser(Request $request) {
    $result = array();
    $userTask=UserTask::where('user_id',$request->user_id)->get();
    $taskbyUser=explode(',', $userTask[0]->tasks_id);
    $task = Task::find($taskbyUser);

    $counterAddedValueReal=0;
    $counterAddedValueEnterprice=0;
    $counterNoAddedValue=0;

    foreach ($task as $t) {
      if(isset($t->addedValue[0]) && isset($t->addedValue[1]) && isset($t->addedValue[2])){
        if($t->addedValue[0]== "4" || $t->addedValue[0] == "5"){
          $counterAddedValueReal ++;
        }elseif ($t->addedValue[1]== "4" || $t->addedValue[1] == "5" || $t->addedValue[2]== "4" || $t->addedValue[2] == "5")  {
          $counterAddedValueEnterprice ++;
        }else{
          $counterNoAddedValue ++;
        }
      }
    }

    $datos = collect();
    $legend = collect();
    $graph_two = collect();

    if($counterAddedValueReal > 0){
      $datos->push(array('value'=>$counterAddedValueReal,'name'=>'Valor real'));
      $legend->push('Valor real');
      $graph_two->push(array('name'=>'Valor real', 'type'=>'bar', 'stack'=> 'VR', 'data'=>array($counterAddedValueReal)));
    }
    if($counterAddedValueEnterprice > 0){
      $datos->push(array('value'=>$counterAddedValueEnterprice,'name'=>'Valor agregado para la empresa'));
      $legend->push('Valor agregado para la empresa');
      $graph_two->push(array('name'=>'Valor agregado para la empresa', 'type'=>'bar', 'stack'=> 'VRE', 'data'=>array($counterAddedValueEnterprice)));
    }
    if($counterNoAddedValue > 0){
      $datos->push(array('value'=>$counterNoAddedValue,'name'=>'Sin valor real'));
      $legend->push('Sin valor real');
      $graph_two->push(array('name'=>'Sin valor real', 'type'=>'bar', 'stack'=> 'NVR', 'data'=>array($counterNoAddedValue)));
    }

    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getAddedValueData(Request $request){
    $project = $request->project_id;
    $tasks = Task::select('id','task','relatedToLevel','allocator','addedValue')->where('project_id',$project)->get();
    $users =  DB::table('user_tasks')
              ->Join('users', function ($join) use($project) {
                  $join->on('users.id', '=', 'user_tasks.user_id')
                  ->where('users.relatedProjects', '=', $project);
              })->select('users.name', 'users.identification', 'user_tasks.tasks_id')->get();

    $result = collect();
    foreach ($users as $user) {
        $type = "";
        $taskAssigned=explode(',', $user->tasks_id);
        foreach ($taskAssigned as $task) {
          $t =$tasks->where('id', $task)->flatten();
          if(isset($t[0]['addedValue'][0]) && isset($t[0]['addedValue'][1]) && isset($t[0]['addedValue'][2])){
            if($t[0]['addedValue'][0]== "4" || $t[0]['addedValue'][0] == "5"){
              $type = "Valor Agregado Real";
            }elseif ($t[0]['addedValue'][1]== "4" || $t[0]['addedValue'][1] == "5" || $t[0]['addedValue'][2]== "4" || $t[0]['addedValue'][2] == "5")  {
              $type = "Valor Agregado para al empresa";
            }else{
              $type = "Sin Valor Agregado";
            }
            $result->push(array('identification'=>$user->identification,
                       'user'=>$user->name,
                       'task'=>$t[0]['task'],
                       'level'=>$t[0]['relatedToLevel'],
                       'product'=>$t[0]['allocator'],
                       'clasification'=>$type,
                      ));
          }
        }
    }
    $title =[
      ['label'=>"Identificación",'field'=> "identification",'numeric'=> false, 'html'=> false],
      ['label'=> "Nombre",'field'=> "user",'numeric'=> false, 'html'=> false],
      ['label'=> "Tarea",'field'=> "task",'numeric'=> false, 'html'=> false],
      ['label'=> "Nivel de estructura",'field'=> "level",'numeric'=> false, 'html'=> false],
      ['label'=> "Producto",'field'=> "product",'numeric'=> false, 'html'=> false],
      ['label'=> "Valor Agregado",'field'=> "clasification",'numeric'=> false, 'html'=> false]
    ];
    return ['content'=> $result, 'title'=> $title];
  }


  /*****CORELACIÓN***/

  public function getCorelationMeasuresByProduct(Request $request){
    $result = array();
    $task = Task::select('correlation', 'task')->where('project_id',$request->project_id)->where('type',$request->product)->whereNotNull('correlation')->get();
    $counter= array();
    foreach ($task as $t) {
      foreach ($t->correlation as $tc){
        if(isset($counter [$tc])){
          $counter [$tc] += 1;
        }else{
          $counter [$tc] = 1;
        }
      }
    }
    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $name = Catalog::Where('id',$key)->get('name')[0]->name;
      $datos->push(array('value'=>$value,'name'=>$name));
      $legend->push($name);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getCorelationMeasuresByLevel(Request $request) {
    $result = array();
    $task = Task::select('correlation')->where('project_id',$request->project_id)->where('relatedToLevel',$request->level)->whereNotNull('correlation')->get();
    $counter= array();
    foreach ($task as $t) {
      foreach ($t->correlation as $tc){
        if(isset($counter [$tc])){
          $counter [$tc] += 1;
        }else{
          $counter [$tc] = 1;
        }
      }
    }
    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $name = Catalog::Where('id',$key)->get('name')[0]->name;
      $datos->push(array('value'=>$value,'name'=>$name));
      $legend->push($name);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getCorelationMeasuresByCorelation(Request $request) {
    $result = array();
    $option= $request->correlation;

    $task = Task::select('correlation', 'task')->where('project_id',$request->project_id)->whereNotNull('correlation')->get();

    $datos = collect();
    $legend = collect();
    $graph_two = collect();

    foreach ($task as $t) {
      if (in_array($option, $t->correlation)){
        $datos->push(array('value'=> 1 ,'name'=>$t->task));
        $legend->push($t->task);
        $graph_two->push(array('name'=>$t->task, 'type'=>'bar', 'stack'=> 'COR', 'data'=>array(1)));
      }
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;
  }

  public function getCorelationMeasuresByUser(Request $request) {
    $result = array();
    $userTask=UserTask::where('user_id',$request->user_id)->get();
    $taskbyUser=explode(',', $userTask[0]->tasks_id);
    $task = Task::find($taskbyUser);

    $counter= array();
    foreach ($task as $t) {
      foreach ($t->correlation as $tc){
        if(isset($counter [$tc])){
          $counter [$tc] += 1;
        }else{
          $counter [$tc] = 1;
        }
      }
    }

    $datos = collect();
    $legend = collect();
    $graph_two = collect();
    foreach ($counter as $key => $value){
      $name = Catalog::Where('id',$key)->get('name')[0]->name;
      $datos->push(array('value'=>$value,'name'=>$name));
      $legend->push($name);
      $graph_two->push(array('name'=>$name, 'type'=>'bar', 'stack'=> $key, 'data'=>array($value)));
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;
    $result['second_graphic']=$graph_two;
    return $result;



  }

  public function getCorelationData(Request $request){
    $project = $request->project_id;
    $tasks = Task::select('id','task','relatedToLevel','allocator','correlation')->where('project_id',$project)->get();
    $users =  DB::table('user_tasks')
              ->Join('users', function ($join) use($project) {
                  $join->on('users.id', '=', 'user_tasks.user_id')
                  ->where('users.relatedProjects', '=', $project);
              })->select('users.name', 'users.identification', 'user_tasks.tasks_id')->get();

    $result = collect();
    foreach ($users as $user) {
        $type = "";
        $taskAssigned=explode(',', $user->tasks_id);
        foreach ($taskAssigned as $task) {
          $t =$tasks->where('id', $task)->flatten();
          foreach ($t[0]['correlation'] as $correlation) {
            $type = Catalog::Where('id',$correlation)->get('name')[0]->name;
            $result->push(
              array('identification'=>$user->identification,
                     'user'=>$user->name,
                     'task'=>$t[0]['task'],
                     'level'=>$t[0]['relatedToLevel'],
                     'product'=>$t[0]['allocator'],
                     'correlation'=>$type,
            ));
          }
        }
    }
    $title =[
      ['label'=>"Identificación",'field'=> "identification",'numeric'=> false, 'html'=> false],
      ['label'=> "Nombre",'field'=> "user",'numeric'=> false, 'html'=> false],
      ['label'=> "Tarea",'field'=> "task",'numeric'=> false, 'html'=> false],
      ['label'=> "Nivel de estructura",'field'=> "level",'numeric'=> false, 'html'=> false],
      ['label'=> "Producto",'field'=> "product",'numeric'=> false, 'html'=> false],
      ['label'=> "Correlación",'field'=> "correlation",'numeric'=> false, 'html'=> false]
    ];
    return ['content'=> $result, 'title'=> $title];
  }
/*** -------------------------------- ****/

  public function getUserMeasures()
  {
    $userMeasures = Measure::where('user_id', Auth::user()->id)->get();
    $categorias = collect();
    foreach ($userMeasures as $measure) {
      $categorias->push(array('value'=>$measure->measure,'name'=>"Tarea ".$measure->measure));
    }
    return $categorias;
  }

  /*Recopila los datos de los dias evaluados por usuario*/
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

    $Promedio = $userParameterMeasures->groupBy('fecha')
                      ->map(function ($row) {return $row->avg('measure');})->flatten();
    return $result;
  }


}
