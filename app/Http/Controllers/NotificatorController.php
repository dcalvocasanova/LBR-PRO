<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Alerting;
use App\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Notifier;

class NotificatorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function sendGoalsNotification(Request $request)
    {
      $users = $request->usersToNotify;
      $this->sendEmailConfirmation($users,$request->title,$request->body,'GOALS');
      foreach ($users as $user) {
          $notification = new Alerting();
          $notification->title =$request->title;
          $notification->project_id =$request->project_id;
          $notification->relatedToLevel =$request->relatedToLevel;
          $notification->body =$request->body;
          $notification->receiver= $user;
          $notification->sender =Auth::user()->id;
          $notification->type ='GOALS';
          $notification->save();
      }
    }

    /**
     * Get unread user's notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function unreadNotifications()
    {
      $user = Auth::user();
      $unreadNotifications = Alerting::where('receiver', $user->id)->where('status','Pending')->get();
      return $unreadNotifications;
    }

    /**
     * Get all user's notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function allNotifications()
    {
      $user = Auth::user();
      $allNotifications = Alerting::where('receiver', $user->id)->orderBy('created_at','desc')->get();
      return $allNotifications;
    }

    /**
     * Get all notifications of Goals Aprovals from a Project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getGoalsNotifications(Request $request)
    {
      $goalsNotifications = Alerting::where('project_id', $request->id)->where('type','GOALS')->get();
      return $goalsNotifications;
    }

    /**
     * Get all notifications of Goals Aprovals from a level on some Project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getGoalsByLevelNotifications(Request $request)
    {
      $goalsNotifications = Alerting::where('project_id', $request->id)
                    ->where('relatedToLevel',$request->relatedTolevel)
                    ->where('type','GOALS')->get();
      return $goalsNotifications;
    }

    /**
     * Get all notifications of Tasks Aprovals from a Project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTasksNotifications(Request $request)
    {
      $tasksNotifications = Alerting::where('project_id', $request->id)->where('type','TASKS')->get();
      return $tasksNotifications;
    }

    /**
     * Get all notifications of Tasks Aprovals from a Project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTasksByLevelNotifications(Request $request)
    {
      $tasksNotifications = Alerting::where('project_id', $request->id)
                ->where('relatedToLevel',$request->relatedTolevel)
                ->where('type','TASKS')->get();
      return $tasksNotifications;
    }

    /**
     * Mark as Acepted
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function markAsOk(Request $request)
    {
      $this->saveAlert($request->id ,"Acepted"," -Aceptada-","Aceptada");
    }
    /**
     * Mark as rejected
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function markAsRejected (Request $request)
    {
      $this->saveAlert($request->id,'Rejected'," -Rechazada-",$request->reasons);
      $notification = Alerting::findOrFail($request->id);
      $user[0] = $notification->sender;
      $msg = "En la notificación:".$notification->body." RECHAZADA POR:".$request->reasons;
      $this->sendEmailConfirmation($user,$notification->title,$msg,'GOAL-REJECTED');
    }

    /**
     * Mark as correcting.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function markAsCorrecting (Request $request)
    {
      $this->saveAlert($request->id,'Correcting'," -En corrección-",'En Corrección');
    }

    /**
     * Mark as corrected
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function markAsCorrected (Request $request)
    {
      $this->saveAlert($request->id,'Corrected'," -Archivada-",'Tarea terminada');
    }

    /**
    * Update status of notification
    */
    function saveAlert (string $id, string $type, string $title, string $reason){
      $notification = Alerting::findOrFail($id);
      $notification->status = $type;
      $notification->title .= $title;
      $notification->reasons = $reason;
      $notification->read_at = Carbon::now();
      $notification->save();
    }

    /**
    * Send Email confirmation to users
    */
    function sendEmailConfirmation($notificator, string $title, string $msj, string $type){
      $users = User::find($notificator);
      $details = [
          'greeting' => 'Un saludo cordial',
          'title' => $title,
          'body' =>  $msj,
          'sender' => Auth::user()->id,
          'type'=> $type,
          'thanks' => 'Visita la plataforma para mayor información',
          'actionText' => 'Ir al sitio web',
          'actionURL' => url('/notificaciones'),
      ];
      Notification::send($users, new Notifier($details)); //send several UserSystemComponent
    }
}
