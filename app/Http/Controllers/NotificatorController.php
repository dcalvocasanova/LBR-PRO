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
        $usuarios = $request->usersToNotify;
        $users = User::find($usuarios);
        $details = [
            'greeting' => 'Un saludo cordial',
            'title' => $request->title,
            'body' => $request->body,
            'sender' => Auth::user()->id,
            'type'=>'GOALS',
            'thanks' => 'Visita la plataforma para mayor información',
            'actionText' => 'Ir al sitio web',
            'actionURL' => url('/notificaciones'),
        ];
        Notification::send($users, new Notifier($details)); //send several UserSystemComponent
        foreach ($users as $user) {
            $notification = new Alerting();
            $notification->title =$request->title;
            $notification->project_id =$request->project_id;
            $notification->body =$request->body;
            $notification->receiver =$user->id;
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
      $unreadNotifications = Alerting::where('receiver', $user->id)
                            ->where('status','Pending')->get();
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
      $allNotifications = Alerting::where('receiver', $user->id)
                                  ->orWhere('sender', $user->id)
                                  ->orderBy('created_at','desc')->get();
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
      $goalsNotifications = Alerting::where('project_id', $request->id)
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
      $tasksNotifications = Alerting::where('project_id', $request->id)
                            ->where('type','TASKS')->get();
      return $tasksNotifications;
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function markAsOk(Request $request)
    {
      $notification = Alerting::findOrFail($request->id);
      $notification->title .=" -Aceptada-";
      $notification->status = 'Acepted';
      $notification->reasons = 'Acepted';
      $notification->read_at = Carbon::now();
      $notification->save();
    }
    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function markAsRejected (Request $request)
    {
      $notification = Alerting::findOrFail($request->id);
      $notification->title .=" -Rechazada-";
      $notification->status = 'Rejected';
      $notification->reasons = $request->reasons;
      $notification->read_at = Carbon::now();
      $notification->save();
      $this->sendEmailConfirmation($notification->body,$notification->reasons,$notification->sender);
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function markAsCorrecting (Request $request)
    {
      $notification = Alerting::findOrFail($request->id);
      $notification->title .=" -En corrección-";
      $notification->status = 'Correcting';
      $notification->reasons = 'En Corrección';
      $notification->read_at = Carbon::now();
      $notification->save();
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function markAsCorrected (Request $request)
    {
      $notification = Alerting::findOrFail($request->id);
      $notification->status = 'Corrected';
      $notification->title .=" -Archivada-";
      $notification->reasons = 'Tarea terminada';
      $notification->read_at = Carbon::now();
      $notification->save();
    }

    /**
    *
    */
    function sendEmailConfirmation(string $msj, string $reason, string $notificator){
      $users = User::find($notificator);
      $details = [
          'greeting' => 'Un saludo cordial, hay una notificación que fue rechazada',
          'title' => "Notificación rechazada",
          'body' => "Mensaje original :". $msj ." <br><br>"."Razón de rechazo :". $reason ,
          'thanks' => 'Es necesario revisar este pendiente',
          'actionText' => 'Ir al sitio web',
          'actionURL' => url('/notificaciones'),
      ];
      Notification::send( $users , new Notifier($details)); //send several UserSystemComponent

    }

}
