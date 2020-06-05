<?php

namespace App\Http\Controllers;

use App\Alerting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\NotificationTraits;

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
     * Send Goals to notify
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function sendGoalsNotification(Request $request,  NotificationTraits $notificator)
    {
      $users = $request->usersToNotify;
      foreach ($users as $user) {
        $notification = $notificator->createAlert($user,'GOALS',$request);
      }
      $mails = $notificator->sendEmailNotificatios($request->usersToNotify,$request->title,$request->body,'GOALS');
    }
    /**
     * Send Goals to notify
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function sendTasksNotification(Request $request,  NotificationTraits $notificator)
    {
      $users = $request->usersToNotify;
      foreach ($users as $user) {
        $notification = $notificator->createAlert($user,'TASK',$request);
        $relation = $notificator->relatedTaskToUser($user,$request->tasksToNotify);
      }
      $mails = $notificator->sendEmailNotificatios($request->usersToNotify,$request->title,$request->body,'GOALS');
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
    public function markAsOk(Request $request,  NotificationTraits $notificator)
    {
      $notification = $notificator->changeTaskStatus($request->id ,"Acepted"," -Aceptada-","Aceptada");
      $notificator->sendEmailNotifications($notification->sender,
                                            "Notificación aceptada",
                                            "La notificación:".$notification->body." FUE ACEPTADA " ,
                                            " Aceptada");
    }
    /**
     * Mark as rejected
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function markAsRejected (Request $request,  NotificationTraits $notificator)
    {
      $notification= $notificator->changeTaskStatus($request->id ,'Rejected'," -Rechazada-", $request->reasons);
      $notificator->sendEmailNotifications($notification->sender,
                                            "Notificación rechazada",
                                            "La notificación:".$notification->body." RECHAZADA POR:".$notification->reasons,
                                            " Rechazada");
    }
}
