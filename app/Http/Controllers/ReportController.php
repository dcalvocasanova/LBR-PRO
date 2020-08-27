<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\Catalog;
use App\UserTask;
use App\Measure;
use App\Parameter;
use App\ParametersMeasure;
use App\SettingsMeasure;
use App\Inefficiency;
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
                ->select('tasks.id','tasks.task','tasks.PHVA', 'tasks.relatedToLevel','tasks.allocator','tasks.PHVA','catalogs.type')->get();

    $users =  DB::table('user_tasks')
              ->Join('users', function ($join) use($project) {
                  $join->on('users.id', '=', 'user_tasks.user_id')
                  ->where('users.relatedProjects', '=', $project);
              })->select('users.name', 'users.identification', 'user_tasks.tasks_id')->get();

    $result = collect();
    foreach ($users as $user) {
        $taskAssigned=explode(',', $user->tasks_id);
        foreach ($taskAssigned as $idTask => $taskReview) {
          $t =$tasks->where('id', $taskReview)->flatten();
          $phva = $t->first()['PHVA'];
          if (!empty($t->first()['type'])){ $phva =$t->first()['type'];}

          if($phva =="P"){$phva_name="Planear";}
          if($phva =="H"){$phva_name="Hacer";}
          if($phva =="V"){$phva_name="Verificar";}
          if($phva =="A"){$phva_name="Actuar";}

          $result->push(
            array('identification'=>$user->identification,
                 'user'=>$user->name,
                 'task'=>$t->first()['task'],
                 'level'=>$t->first()['relatedToLevel'],
                 'product'=>$t->first()['allocator'],
                 'PHVA'=>$phva_name,
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
                ->select('tasks.id','tasks.task','tasks.competence', 'tasks.relatedToLevel','tasks.allocator','catalogs.type', 'catalogs.name')->get();

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
                         'task'=>$t->first()['task'],
                         'level'=>$t->first()['relatedToLevel'],
                         'product'=>$t->first()['allocator'],
                         'competence'=>$t->first()['name'],
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
                         'task'=>$t->first()['task'],
                         'level'=>$t->first()['relatedToLevel'],
                         'product'=>$t->first()['allocator'],
                         'effort'=>$t->first()['effort'],
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
                ->select('tasks.id','tasks.task','tasks.laborType', 'tasks.relatedToLevel','tasks.allocator','catalogs.type', 'catalogs.name')->get();

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
                         'task'=>$t->first()['task'],
                         'level'=>$t->first()['relatedToLevel'],
                         'product'=>$t->first()['allocator'],
                         'laborType'=>$t->first()['name'],
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
          $t =$tasks->where('id', $taskReview)->flatten()->first();
          $result->push(array('identification'=>$user->identification,
                         'user'=>$user->name,
                         'task'=>$t['task'],
                         'level'=>$t['relatedToLevel'],
                         'product'=>$t['allocator'],
                         'risk'=>$t['name'],
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
          $t =$tasks->where('id', $task)->flatten()->first();
          if(isset($t['addedValue'][0]) && isset($t['addedValue'][1]) && isset($t['addedValue'][2])){
            if($t['addedValue'][0]== "4" || $t['addedValue'][0] == "5"){
              $type = "Valor Agregado Real";
            }elseif ($t['addedValue'][1]== "4" || $t['addedValue'][1] == "5" || $t['addedValue'][2]== "4" || $t['addedValue'][2] == "5")  {
              $type = "Valor Agregado para al empresa";
            }else{
              $type = "Sin Valor Agregado";
            }
            $result->push(array('identification'=>$user->identification,
                       'user'=>$user->name,
                       'task'=>$t['task'],
                       'level'=>$t['relatedToLevel'],
                       'product'=>$t['allocator'],
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
          $t =$tasks->where('id', $task)->flatten()->first();
          $correlations=$t['correlation'];
          foreach ( (array)$correlations as $correlation) {
            $type = Catalog::Where('id',$correlation)->get('name')->first()['name'];
            $result->push(
              array('identification'=>$user->identification,
                     'user'=>$user->name,
                     'task'=>$t['task'],
                     'level'=>$t['relatedToLevel'],
                     'product'=>$t['allocator'],
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

  /*****INSTRUMENTOS***/
  public function getInstrumentsMeasuresByProduct(Request $request){
    $result = array();
    $task= task::leftJoin('measures', 'measures.task_id', '=', 'tasks.id')
                ->where('tasks.project_id',$request->project_id)
                ->where('tasks.type',$request->product)
                ->whereNotNull('measures.measure')
                ->select('tasks.id','tasks.task', 'tasks.t_avg', 'measures.measure')->get();

    $counter = $task->groupBy([
        'id', function ($item) { return ['id'=>$item->id];},
    ], $preserveKeys = true);

    $avg_t= collect();

    foreach ($counter as $key=> $value) {
      $condition="sobrestimado";
      $avg = $value[$key]->avg('measure');
      if($avg > $value[$key]->pluck('t_avg')->first()){
        $condition="subestimado";
      }
      $avg_t->push(array('task'=>$value[$key]->pluck('task')->first(),
              'time'=>$value[$key]->pluck('t_avg')->first(),
              'avg'=> $avg,
              'condition'=>$condition)
            );
    }
    //Data for table
    $title =[
      ['label'=>"Tarea",'field'=> "task",'numeric'=> false, 'html'=> false],
      ['label'=> "Tiempo registrado",'field'=> "time",'numeric'=> false, 'html'=> false],
      ['label'=> "Tiempo promediado",'field'=> "avg",'numeric'=> false, 'html'=> false],
      ['label'=> "Condición",'field'=> "condition",'numeric'=> false, 'html'=> false]
    ];

    $result['content'] = $avg_t;
    $result['title'] = $title;

    $participation =  $avg_t->countBy(function ($item) {
      return $item['condition'];
    });

    $datos = collect();
    $legend = collect();
    foreach ($participation as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;

    return $result;
  }

  public function getInstrumentsMeasuresByLevel(Request $request) {
    $result = array();
    $task= task::leftJoin('measures', 'measures.task_id', '=', 'tasks.id')
                ->where('tasks.project_id',$request->project_id)
                ->where('tasks.relatedToLevel',$request->level)
                ->whereNotNull('measures.measure')
                ->select('tasks.id','tasks.task', 'tasks.t_avg', 'measures.measure')->get();

    $counter = $task->groupBy([
        'id', function ($item) { return ['id'=>$item->id];},
    ], $preserveKeys = true);

    $avg_t= collect();

    foreach ($counter as $key=> $value) {
      $condition="sobrestimado";
      $avg = $value[$key]->avg('measure');
      if($avg > $value[$key]->pluck('t_avg')->first()){
        $condition="subestimado";
      }
      $avg_t->push(array('task'=>$value[$key]->pluck('task')->first(),
              'time'=>$value[$key]->pluck('t_avg')->first(),
              'avg'=> $avg,
              'condition'=>$condition)
            );
    }
    //Data for table
    $title =[
      ['label'=>"Tarea",'field'=> "task",'numeric'=> false, 'html'=> false],
      ['label'=> "Tiempo registrado",'field'=> "time",'numeric'=> false, 'html'=> false],
      ['label'=> "Tiempo promediado",'field'=> "avg",'numeric'=> false, 'html'=> false],
      ['label'=> "Condición",'field'=> "condition",'numeric'=> false, 'html'=> false]
    ];

    $result['content'] = $avg_t;
    $result['title'] = $title;

    $participation =  $avg_t->countBy(function ($item) {
      return $item['condition'];
    });

    $datos = collect();
    $legend = collect();
    foreach ($participation as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;

    return $result;
  }

  public function getInstrumentsMeasuresByUser(Request $request) {
    $result = array();
    $task= task::leftJoin('measures', 'measures.task_id', '=', 'tasks.id')
                ->where('measures.user_id',$request->user_id)
                ->whereNotNull('measures.measure')
                ->select('tasks.id','tasks.task', 'tasks.t_avg', 'measures.measure')->get();
    $counter = $task->groupBy([
        'id', function ($item) { return ['id'=>$item->id];},
    ], $preserveKeys = true);

    $avg_t= collect();

    foreach ($counter as $key=> $value) {
      $condition="sobrestimado";
      $avg = $value[$key]->avg('measure');
      if($avg > $value[$key]->pluck('t_avg')->first()){
        $condition="subestimado";
      }
      $avg_t->push(array('task'=>$value[$key]->pluck('task')->first(),
              'time'=>$value[$key]->pluck('t_avg')->first(),
              'avg'=> $avg,
              'condition'=>$condition)
            );
    }
    //Data for table
    $title =[
      ['label'=>"Tarea",'field'=> "task",'numeric'=> false, 'html'=> false],
      ['label'=> "Tiempo registrado",'field'=> "time",'numeric'=> false, 'html'=> false],
      ['label'=> "Tiempo promediado",'field'=> "avg",'numeric'=> false, 'html'=> false],
      ['label'=> "Condición",'field'=> "condition",'numeric'=> false, 'html'=> false]
    ];

    $result['content'] = $avg_t;
    $result['title'] = $title;

    $participation =  $avg_t->countBy(function ($item) {
      return $item['condition'];
    });

    $datos = collect();
    $legend = collect();
    foreach ($participation as $key => $value){
      $datos->push(array('value'=>$value,'name'=>$key));
      $legend->push($key);
    }
    $result['data'] =$datos;
    $result['legend'] =$legend;

    return $result;
  }

/*** ABC ****/

public function getABCMeasuresByProduct(Request $request){
  $result = array();
  //obtener las tareas
  $task= task::leftJoin('measures', 'measures.task_id', '=', 'tasks.id')
              ->where('tasks.project_id',$request->project_id)
              ->where('tasks.type',$request->product)
              ->whereNotNull('measures.measure')
              ->select('tasks.id','tasks.task', 'tasks.t_avg', 'measures.measure', 'measures.user_id')->get();

  //agrupar las tareas por id de la tarea y luego por usuario
  $groupedTask = $task->groupBy([
      'id', function ($item) { return ['user_id'=>$item->user_id];},
  ], $preserveKeys = true);


  $avgTimePerUserInTask= collect();

  foreach ( $groupedTask as $taskId=> $taskInformation) { //por cada tarea obtenida
    foreach ($taskInformation as $userId => $userTaskInformation) { //obtenemos los datos obtenidos
      $userInformation = User::find($userId, ['salary', 'workday']);
      if (is_numeric($userInformation['salary']) && is_numeric($userInformation['workday']) ){
        $averageTimePerUser = $userTaskInformation->avg('measure'); //promedio de tiempo en tareas
        $costPerMinute = $userInformation['salary'] / $userInformation['workday'];
        $cost = $averageTimePerUser * $costPerMinute; //Costo de cada tarea por usuario
        $avgTimePerUserInTask->push(
          array('task_id'=> $userTaskInformation->pluck('id')->first(),
                'task'=>$userTaskInformation->pluck('task')->first(),
                'minuteSpent'=>$averageTimePerUser,
                'userId'=> $userId,
                'userCost'=>$costPerMinute,
                'cost'=> $cost)
        );
      }
    }
  } //Ya tenemos listo por cada tarea el costo en tiempo por usuario

  //Hay que sumar el costo de las tareas y obtener un Total de costo por tarea entre tdos los usuarios

  $SumCostPerTask = $avgTimePerUserInTask->groupBy('task_id', $preserveKeys = true)->map(function ($row) {
    return ['costActivity'=>$row->sum('cost'), 'task'=>$row];
  });

  //Costo total de todas las tareas
  $totalCost = $SumCostPerTask->sum('costActivity');

  //Ordenamos latareas por orden de costo
  $OrderingTaskByCost = $SumCostPerTask->sortByDesc('costActivity');
  $TaskInOrder = $OrderingTaskByCost->values()->all();

  //Obtenemos la clasificación A B o C
  $taskCategory=collect();

  $cumulativePercentage=0;
  foreach ($TaskInOrder as $activity) {
    $taskCostPercentage =  round(($activity['costActivity'] /$totalCost)*100, PHP_ROUND_HALF_DOWN);
    $cumulativePercentage+= $taskCostPercentage;
    if($cumulativePercentage < 80){
      $category = 'A';
    }elseif ($cumulativePercentage < 95) {
      $category = 'B';
    }else {
      $category = 'C';
    }
    $taskCategory->push(
      array('task'=>$activity['task']->first()['task'],
            'percentage'=> $taskCostPercentage,
            'costActivity'=>$activity['costActivity'] ,
            'cumulativePercentage'=> $cumulativePercentage,
            'category'=> $category
      )
    );
  }
  //agrupar las tareas por A,B o C
  $groupedTaskbyABC = $taskCategory->groupBy('category', $preserveKeys = true)->map(function ($row) {
    return [
      'costActivity'=>$row->sum('costActivity'),
      'percentage'=>$row->sum('percentage'),
      'quantity'=>$row->count('task'),
      'task'=>$row];
  });

  $totalActivities = $groupedTaskbyABC->sum('quantity');
  $data=collect();
  $cumulativeData=collect();
  $legend=collect();
  $tableData=collect();
  $cumulativeCaculatePercentage=0;
  //Preparar datos para mostrarse en gráficos y tabla
  foreach ($groupedTaskbyABC as $category=>$abcTask) {
    $activityPercentage=  round(($abcTask['quantity'] /$totalActivities)*100, PHP_ROUND_HALF_DOWN);
    $data->push($activityPercentage);
    $cumulativeCaculatePercentage+=$abcTask['percentage'];
    $cumulativeData->push(round($cumulativeCaculatePercentage));
    $legend->push($category);
    foreach ($abcTask['task'] as $taskId => $taskDetails) {
      $tableData->push(
          array('task' => $taskDetails['task'],
                'cost' => $taskDetails['costActivity'],
                'percentage' => round($taskDetails['percentage']),
                'cumulativePercentage'=> round($taskDetails['cumulativePercentage']),
                'category' => $taskDetails['category'])
        );
    }
  }

  $title =[
    ['label'=>"Tarea",'field'=> "task",'numeric'=> false, 'html'=> false],
    ['label'=> "Costo de la tarea",'field'=> "cost",'numeric'=> true, 'html'=> false],
    ['label'=> "%",'field'=> "percentage",'numeric'=> true, 'html'=> false],
    ['label'=> "% acumulado",'field'=> "cumulativePercentage",'numeric'=> true, 'html'=> false],
    ['label'=> "Categoría",'field'=> "category",'numeric'=> false, 'html'=> false]
  ];
  $result['data'] =$data;
  $result['cumulative'] =$cumulativeData;
  $result['legend'] =$legend;
  $result['content'] = $tableData;
  $result['title'] = $title;
  return $result;
}

public function getABCMeasuresByLevel(Request $request) {
  $result = array();
  //obtener las tareas
  $task= task::leftJoin('measures', 'measures.task_id', '=', 'tasks.id')
              ->where('tasks.project_id',$request->project_id)
              ->where('tasks.relatedToLevel',$request->level)
              ->whereNotNull('measures.measure')
              ->select('tasks.id','tasks.task', 'tasks.t_avg', 'measures.measure', 'measures.user_id')->get();

  //agrupar las tareas por id de la tarea y luego por usuario
  $groupedTask = $task->groupBy([
      'id', function ($item) { return ['user_id'=>$item->user_id];},
  ], $preserveKeys = true);


  $avgTimePerUserInTask= collect();

  foreach ( $groupedTask as $taskId=> $taskInformation) { //por cada tarea obtenida
    foreach ($taskInformation as $userId => $userTaskInformation) { //obtenemos los datos obtenidos
      $userInformation = User::find($userId, ['salary', 'workday']);
      if (is_numeric($userInformation['salary']) && is_numeric($userInformation['workday']) ){
        $averageTimePerUser = $userTaskInformation->avg('measure'); //promedio de tiempo en tareas
        $costPerMinute = $userInformation['salary'] / $userInformation['workday'];
        $cost = $averageTimePerUser * $costPerMinute; //Costo de cada tarea por usuario
        $avgTimePerUserInTask->push(
          array('task_id'=> $userTaskInformation->pluck('id')->first(),
                'task'=>$userTaskInformation->pluck('task')->first(),
                'minuteSpent'=>$averageTimePerUser,
                'userId'=> $userId,
                'userCost'=>$costPerMinute,
                'cost'=> $cost)
        );
      }
    }
  } //Ya tenemos listo por cada tarea el costo en tiempo por usuario

  //Hay que sumar el costo de las tareas y obtener un Total de costo por tarea entre tdos los usuarios

  $SumCostPerTask = $avgTimePerUserInTask->groupBy('task_id', $preserveKeys = true)->map(function ($row) {
    return ['costActivity'=>$row->sum('cost'), 'task'=>$row];
  });

  //Costo total de todas las tareas
  $totalCost = $SumCostPerTask->sum('costActivity');

  //Ordenamos latareas por orden de costo
  $OrderingTaskByCost = $SumCostPerTask->sortByDesc('costActivity');
  $TaskInOrder = $OrderingTaskByCost->values()->all();

  //Obtenemos la clasificación A B o C
  $taskCategory=collect();

  $cumulativePercentage=0;
  foreach ($TaskInOrder as $activity) {
    $taskCostPercentage =  round(($activity['costActivity'] /$totalCost)*100, PHP_ROUND_HALF_DOWN);
    $cumulativePercentage+= $taskCostPercentage;
    if($cumulativePercentage < 80){
      $category = 'A';
    }elseif ($cumulativePercentage < 95) {
      $category = 'B';
    }else {
      $category = 'C';
    }
    $taskCategory->push(
      array('task'=>$activity['task']->first()['task'],
            'percentage'=> $taskCostPercentage,
            'costActivity'=>$activity['costActivity'] ,
            'cumulativePercentage'=> $cumulativePercentage,
            'category'=> $category
      )
    );
  }
  //agrupar las tareas por A,B o C
  $groupedTaskbyABC = $taskCategory->groupBy('category', $preserveKeys = true)->map(function ($row) {
    return [
      'costActivity'=>$row->sum('costActivity'),
      'percentage'=>$row->sum('percentage'),
      'quantity'=>$row->count('task'),
      'task'=>$row];
  });

  $totalActivities = $groupedTaskbyABC->sum('quantity');
  $data=collect();
  $cumulativeData=collect();
  $legend=collect();
  $tableData=collect();
  $cumulativeCaculatePercentage=0;
  //Preparar datos para mostrarse en gráficos y tabla
  foreach ($groupedTaskbyABC as $category=>$abcTask) {
    $activityPercentage=  round(($abcTask['quantity'] /$totalActivities)*100, PHP_ROUND_HALF_DOWN);
    $data->push($activityPercentage);
    $cumulativeCaculatePercentage+=$abcTask['percentage'];
    $cumulativeData->push(round($cumulativeCaculatePercentage));
    $legend->push($category);
    foreach ($abcTask['task'] as $taskId => $taskDetails) {
      $tableData->push(
          array('task' => $taskDetails['task'],
                'cost' => $taskDetails['costActivity'],
                'percentage' => round($taskDetails['percentage']),
                'cumulativePercentage'=> round($taskDetails['cumulativePercentage']),
                'category' => $taskDetails['category'])
        );
    }
  }

  $title =[
    ['label'=>"Tarea",'field'=> "task",'numeric'=> false, 'html'=> false],
    ['label'=> "Costo de la tarea",'field'=> "cost",'numeric'=> true, 'html'=> false],
    ['label'=> "%",'field'=> "percentage",'numeric'=> true, 'html'=> false],
    ['label'=> "% acumulado",'field'=> "cumulativePercentage",'numeric'=> true, 'html'=> false],
    ['label'=> "Categoría",'field'=> "category",'numeric'=> false, 'html'=> false]
  ];
  $result['data'] =$data;
  $result['cumulative'] =$cumulativeData;
  $result['legend'] =$legend;
  $result['content'] = $tableData;
  $result['title'] = $title;
  return $result;
}

/**** CARGAS DE TRABAJO****/

public function getWorkFlow(Request $request) {
  $result = array();
  //Obtener las tareas y medidas de los instrumentos según el usuario
  $task= task::leftJoin('measures', 'measures.task_id', '=', 'tasks.id')
              ->where('measures.user_id',$request->user_id)
              ->whereNotNull('measures.measure')
              ->select('tasks.id','tasks.task', 'tasks.allocator', 'measures.fecha', 'measures.measure')->get();
  $userParameterMeasures = ParametersMeasure::leftJoin('variables','parameters_measures.category_id','=','variables.id')
                          ->LeftJoin('subparameters','variables.subparameter_id','=', 'subparameters.id')
                          ->LeftJoin('parameters','subparameters.parameter_id','=','parameters.id')
                          ->where('user_id', $request->user_id)
                          ->select('parameters_measures.id',
                                  'parameters_measures.category_id',
                                  'parameters_measures.variable',
                                  'parameters_measures.fecha',
                                  'parameters_measures.measure',
                                  'variables.identificator',
                                  'subparameters.name AS category',
                                  'parameters.name AS parameter')->get();
  $tasksGrouped= $task->groupBy([
      'fecha', function ($row) {return $row['id'];},
  ], $preserveKeys = true);

  //Agrupar todo por fechas
  $userParameterMeasuresGrouped = $userParameterMeasures->groupBy([
      'fecha',function ($row) {return $row['id'];},
  ], $preserveKeys = true);

  //Hacer el reporte con el promedio de tareas
  $tasksReport= collect();
  foreach ($tasksGrouped as $key => $registeredTasks) {
    foreach ($registeredTasks as $id => $evaluatedTask) {
      $tasksReport->push(
        array('day'=>$evaluatedTask->first()->fecha,
              'process'=>$evaluatedTask->first()->allocator,
              'task'=>$evaluatedTask->first()->task,
              'measure'=> $evaluatedTask->first()->measure
        )
      );
    }
  }

  //Hacer el reporte con el promedio de los tiempos evaluados
  $timesReport= collect();
  foreach ($userParameterMeasuresGrouped as $key => $registeredTimes) {
    foreach ($registeredTimes as $id => $evaluatedTime) {
      $timesReport->push(
        array('day'=>$evaluatedTime->first()->fecha,
              'type'=>$evaluatedTime->first()->parameter,
              'category'=>$evaluatedTime->first()->category,
              'identificator'=>$evaluatedTime->first()->identificator,
              'variable'=>$evaluatedTime->first()->variable,
              'measure'=> $evaluatedTime->first()->measure
        )
      );
    }
  }

  //títulos tabla de tareas
  $titleTaskReport =[
    ['label'=>"Día",'field'=> "day",'numeric'=> false, 'html'=> false],
    ['label'=> "Proceso",'field'=> "process",'numeric'=> false, 'html'=> false],
    ['label'=> "Tarea",'field'=> "task",'numeric'=> false, 'html'=> false],
    ['label'=> "Medida",'field'=> "measure",'numeric'=> false, 'html'=> false]
  ];
  //títulos tabla de tiempos
  $titleTimesReport =[
    ['label'=>"Día",'field'=> "day",'numeric'=> false, 'html'=> false],
    ['label'=> "Tipo",'field'=> "type",'numeric'=> false, 'html'=> false],
    ['label'=> "Categoría",'field'=> "category",'numeric'=> false, 'html'=> false],
    ['label'=> "Identificador",'field'=> "identificator",'numeric'=> false, 'html'=> false],
    ['label'=> "Variable",'field'=> "variable",'numeric'=> false, 'html'=> false],
    ['label'=> "Medida",'field'=> "measure",'numeric'=> false, 'html'=> false]
  ];
  //Enviar datos
  $result['tasks'] = $tasksReport;
  $result['titleTasks'] = $titleTaskReport;
  $result['times'] = $timesReport;
  $result['titleTimes'] = $titleTimesReport;
  return $result;
}

/**** TIEMPOS DE AJUSTE ****/
public function getTimesByUser(Request $request){
    $datos = SettingsMeasure::where('project_id', $request->project_id)->first();
    $dailyWorkHours=$datos->workdays;
    $workingDaysPerWeek=$datos->weekdays;
    $workingDaysPerYear=$datos->yeardays;
    $incapacityRate=$datos->disability;
    $holyday=$datos->vacation;
    $daysOff=$datos->license;
    $trainingInHours=$datos->training;
    $dailyWorkMinutes=$dailyWorkHours*60;
    $fatigue=0.04;
    $employees=User::where('relatedProjects', $request->project_id)->count();

    if($dailyWorkHours <= 0){$dailyWorkHours=8;}
    if($workingDaysPerYear <= 0){$workingDaysPerYear=365;}
    if($employees <= 0){$employees=1;}

    $trainingPercentage = (($trainingInHours/$dailyWorkHours)*(1/($workingDaysPerYear*$employees)));
    $holydayPercentage =($holyday/($workingDaysPerYear*$employees));
    $incapacityPercentage=($incapacityRate/($workingDaysPerYear*$employees));
    $daysOffPercentage=($daysOff/($workingDaysPerYear*$employees));

    //Obtener los parametros del usuario
    $times = ParametersMeasure::leftJoin('variables','parameters_measures.category_id','=','variables.id')
              ->LeftJoin('subparameters','variables.subparameter_id','=', 'subparameters.id')
              ->LeftJoin('parameters','subparameters.parameter_id','=','parameters.id')
              ->where('user_id', $request->user_id)
              ->select('parameters_measures.fecha',
                      'parameters_measures.measure',
                      'variables.identificator',
                      'parameters.name AS parameter')->get();

      //Agrupar todo por categoría de tiempo a evaluar y obtener promedio entre las distintas fechas en que se midió
    $avgTimes = $times->groupBy('identificator')
                       ->map(function ($row){
                           $addition['total'] = $row->avg('measure');
                           $addition['category'] = $row->first()['parameter'];
                           return $addition;
                        });
    //Agrupar por categoría de medición y promediar tiempos
    $avgCategoryTimes = $avgTimes->groupBy('category')
                        ->map(function ($row){
                            return $row->sum('total');
                         });
    $categoryObjectTimes = $avgCategoryTimes->sum();
    //Cálculos propios para estimar de tiempo básico
    $timingVariables = $categoryObjectTimes;
    $timingVariables += $dailyWorkMinutes * $trainingPercentage;
    $timingVariables += $dailyWorkMinutes * $incapacityPercentage;
    $timingVariables += $dailyWorkMinutes * $holydayPercentage;
    $timingVariables += $dailyWorkMinutes * $daysOffPercentage;
    $timingVariables += $dailyWorkMinutes * $fatigue;

    $basicTime = $dailyWorkMinutes - $timingVariables;

    //Cálculos propios para calculo de tiempo extra: 1.Obtener Tiempo total
    $tasks= Measure::where('user_id',$request->user_id)
                    ->whereNotNull('measures.measure')
                    ->select('fecha', 'measure')->get();
    //Agrupar todo por fecha para obtener suma de tiempos
    $sumTasks= $tasks->groupBy('fecha')
                      ->map(function($row){
                          return $row->sum('measure');
                      });
    //Promedio de tiempos para obtener tiempos de medición de tareas
    $categoryTasksTime = $sumTasks->avg();
    //Totalizar jornada que fue medida
    $totalTimeResearch= $categoryObjectTimes+$categoryTasksTime;

    //Calcular tiempos extra
    $extraTimeMinutes = $totalTimeResearch - $dailyWorkMinutes;
    if($extraTimeMinutes > 0){
      $extraTime = $extraTimeMinutes;
      $extraTime += ($extraTimeMinutes * $trainingPercentage);
      $extraTime += ($extraTimeMinutes * $incapacityPercentage);
      $extraTime += ($extraTimeMinutes * $holydayPercentage);
      $extraTime += ($extraTimeMinutes * $daysOffPercentage);
    }else{ $extraTime=0;}


    $graph= collect();
    $inefficiencyValue=0;
    //Obtenemos los datos para saber qué tiempos miden la ineficiencia
    $parameters = Inefficiency::first();
    $parametersId = explode(",",$parameters->field_related);
    $inefficiencyData=Parameter::find($parametersId,['name'])->keyBy('name');
    $inefficiency = $inefficiencyData->keys();

    $percentage = ($basicTime/$dailyWorkMinutes)*100;
    $graph->push(array('name'=>'Tiempo Básico','type'=>'bar','stack'=> 'TIMES','data'=> array(round($percentage, PHP_ROUND_HALF_DOWN))));
    foreach ($avgCategoryTimes as $category => $total) {
      $percentage = ($total/$dailyWorkMinutes)*100;
      $categoryStr =strval($category);
      $data=$inefficiency->map(function ($item) use($category,$percentage) {
          if($item == $category){ return ($percentage/100);}else{return 0;}
        });
      $inefficiencyValue+= $data->sum();
      $graph->push(
        array(
          'name'=>$category,
          'type'=>'bar',
          'stack'=>'TIMES',
          'data'=>array(round($percentage, PHP_ROUND_HALF_DOWN))
        )
      );
    }
    //Elementos adicionales
    $graph->push(array('name'=>'Incapacidades','type'=>'bar','stack'=>'TIMES','data'=> array(round($incapacityPercentage*100, PHP_ROUND_HALF_DOWN))));
    $graph->push(array('name'=>'Vacaciones','type'=>'bar','stack'=>'TIMES','data'=> array(round($holydayPercentage*100, PHP_ROUND_HALF_DOWN))));
    $graph->push(array('name'=>'Permisos','type'=>'bar','stack'=>'TIMES','data'=> array(round($daysOffPercentage*100, PHP_ROUND_HALF_DOWN))));
    $graph->push(array('name'=>'Capacitación','type'=>'bar','stack'=>'TIMES','data'=> array(round($trainingPercentage*100, PHP_ROUND_HALF_DOWN))));
    $graph->push(array('name'=>'Fatiga','type'=>'bar','stack'=>'TIMES','data'=> array(round($fatigue*100, PHP_ROUND_HALF_DOWN))));
    $percentage = ($extraTime/$dailyWorkMinutes)*100;
    $graph->push(array('name'=>'Extra','type'=>'bar','stack'=> 'TIMES','data'=> array(round($percentage, PHP_ROUND_HALF_DOWN))));
    // Tiempo objeto
    $report['data'] =$graph;
    $report['inefficiency'] =$inefficiencyValue;
    $report['users'] =1;

    return $report;
}

public function getTimesByLevel(Request $request){
    $datos = SettingsMeasure::where('project_id', $request->project_id)->first();
    $dailyWorkHours=$datos->workdays;
    $workingDaysPerWeek=$datos->weekdays;
    $workingDaysPerYear=$datos->yeardays;
    $incapacityRate=$datos->disability;
    $holyday=$datos->vacation;
    $daysOff=$datos->license;
    $trainingInHours=$datos->training;

    $dailyWorkMinutes=$dailyWorkHours*60;
    $fatigue=0.04;
    $employees=User::where('relatedProjects', $request->project_id)->count();
    $users=User::where('relatedLevel', $request->level)->get('id');
    $userToConsult=collect();
    foreach ($users as $tag => $id) { $userToConsult->push($id->id);}

    if($dailyWorkHours <= 0){$dailyWorkHours=8;}
    if($workingDaysPerYear <= 0){$workingDaysPerYear=365;}
    if($employees <= 0){$employees=1;}

    $trainingPercentage = (($trainingInHours/$dailyWorkHours)*(1/($workingDaysPerYear*$employees)));
    $holydayPercentage =($holyday/($workingDaysPerYear*$employees));
    $incapacityPercentage=($incapacityRate/($workingDaysPerYear*$employees));
    $daysOffPercentage=($daysOff/($workingDaysPerYear*$employees));

    //Obtener los parametros del usuario
    $times = ParametersMeasure::leftJoin('variables','parameters_measures.category_id','=','variables.id')
              ->LeftJoin('subparameters','variables.subparameter_id','=', 'subparameters.id')
              ->LeftJoin('parameters','subparameters.parameter_id','=','parameters.id')
              ->whereIn('user_id', $userToConsult)
              ->select('parameters_measures.fecha',
                      'parameters_measures.measure',
                      'variables.identificator',
                      'parameters.name AS parameter')->get();

    //Agrupar todo por categoría de tiempo a evaluar y obtener promedio entre las distintas fechas en que se midió
    $avgTimes = $times->groupBy('identificator')
                       ->map(function ($row){
                           $addition['total'] = $row->avg('measure');
                           $addition['category'] = $row->first()['parameter'];
                           return $addition;
                        });
    //Agrupar por categoría de medición y promediar tiempos
    $avgCategoryTimes = $avgTimes->groupBy('category')
                        ->map(function ($row){
                            return $row->sum('total');
                         });
    $categoryObjectTimes = $avgCategoryTimes->sum();
    //Cálculos propios para estimar de tiempo básico
    $timingVariables = $categoryObjectTimes;
    $timingVariables += $dailyWorkMinutes * $trainingPercentage;
    $timingVariables += $dailyWorkMinutes * $incapacityPercentage;
    $timingVariables += $dailyWorkMinutes * $holydayPercentage;
    $timingVariables += $dailyWorkMinutes * $daysOffPercentage;
    $timingVariables += $dailyWorkMinutes * $fatigue;

    $basicTime = $dailyWorkMinutes - $timingVariables;

    //Cálculos propios para calculo de tiempo extra: 1.Obtener Tiempo total
    $tasks= Measure::whereIn('user_id', $userToConsult)
                    ->whereNotNull('measures.measure')
                    ->select('fecha', 'measure')->get();
    //Agrupar todo por fecha para obtener suma de tiempos
    $sumTasks= $tasks->groupBy('fecha')
                      ->map(function($row){
                          return $row->sum('measure');
                      });
    //Promedio de tiempos para obtener tiempos de medición de tareas
    $categoryTasksTime = $sumTasks->avg();
    //Totalizar jornada que fue medida
    $totalTimeResearch= $categoryObjectTimes+$categoryTasksTime;

    //Calcular tiempos extra
    $extraTimeMinutes = $totalTimeResearch - $dailyWorkMinutes;
    if($extraTimeMinutes > 0){
      $extraTime = $extraTimeMinutes;
      $extraTime += ($extraTimeMinutes * $trainingPercentage);
      $extraTime += ($extraTimeMinutes * $incapacityPercentage);
      $extraTime += ($extraTimeMinutes * $holydayPercentage);
      $extraTime += ($extraTimeMinutes * $daysOffPercentage);
    }else{ $extraTime=0;}


    $graph= collect();
    $inefficiencyValue=0;
    //Obtenemos los datos para saber qué tiempos miden la ineficiencia
    $parameters = Inefficiency::first();
    $parametersId = explode(",",$parameters->field_related);
    $inefficiencyData=Parameter::find($parametersId,['name'])->keyBy('name');
    $inefficiency = $inefficiencyData->keys();

    $percentage = ($basicTime/$dailyWorkMinutes)*100;
    $graph->push(array('name'=>'Tiempo Básico','type'=>'bar','stack'=> 'TIMES','data'=> array(round($percentage, PHP_ROUND_HALF_DOWN))));
    foreach ($avgCategoryTimes as $category => $total) {
      $percentage = ($total/$dailyWorkMinutes)*100;
      $categoryStr =strval($category);
      $data=$inefficiency->map(function ($item) use($category,$percentage) {
          if($item == $category){ return ($percentage/100);}else{return 0;}
        });
      $inefficiencyValue+= $data->sum();
      $graph->push(
        array(
          'name'=>$category,
          'type'=>'bar',
          'stack'=>'TIMES',
          'data'=>array(round($percentage, PHP_ROUND_HALF_DOWN))
        )
      );
    }
    //Elementos adicionales
    $graph->push(array('name'=>'Incapacidades','type'=>'bar','stack'=>'TIMES','data'=> array(round($incapacityPercentage*100, PHP_ROUND_HALF_DOWN))));
    $graph->push(array('name'=>'Vacaciones','type'=>'bar','stack'=>'TIMES','data'=> array(round($holydayPercentage*100, PHP_ROUND_HALF_DOWN))));
    $graph->push(array('name'=>'Permisos','type'=>'bar','stack'=>'TIMES','data'=> array(round($daysOffPercentage*100, PHP_ROUND_HALF_DOWN))));
    $graph->push(array('name'=>'Capacitación','type'=>'bar','stack'=>'TIMES','data'=> array(round($trainingPercentage*100, PHP_ROUND_HALF_DOWN))));
    $graph->push(array('name'=>'Fatiga','type'=>'bar','stack'=>'TIMES','data'=> array(round($fatigue*100, PHP_ROUND_HALF_DOWN))));
    $percentage = ($extraTime/$dailyWorkMinutes)*100;
    $graph->push(array('name'=>'Extra','type'=>'bar','stack'=> 'TIMES','data'=> array(round($percentage, PHP_ROUND_HALF_DOWN))));
    // Tiempo objeto
    $report['data'] =$graph;
    $report['inefficiency'] =$inefficiencyValue;
    $report['users'] =sizeof($users);

    return $report;
  }
}
