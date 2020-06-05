<?php

namespace App\Traits;

use App\User;
use App\Alerting;
use App\UserTask;
use Carbon\Carbon;

use App\Notifications\Notifier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotificationTraits
{
  public function createAlert($user, $type, $details)
  {
    $notification = Alerting::firstOrNew(['receiver' => $user],['type' => $type]);
    $notification->title = $details->title;
    $notification->project_id = $details->project_id;
    $notification->relatedToLevel = $details->relatedToLevel;
    $notification->body = $details->body;
    $notification->receiver= $user;
    $notification->sender = Auth::user()->id;
    $notification->type = $type;
    $notification->status = 'Pending';
    $notification->save();
    return  $notification;
  }
  public function relatedTaskToUser($user, $tasks)
  {
    $relation = UserTask::firstOrNew(['user_id' => $user]);
    $relation->user_id = $user;
    $relation->tasks_id = $tasks;
    $relation->save();
    return  $relation;
  }
  public function changeTaskStatus (string $id, string $type, string $title, string $reason){
    $notification = Alerting::findOrFail($id);
    $notification->status = $type;
    $notification->title .= $title;
    $notification->reasons = $reason;
    $notification->read_at = Carbon::now();
    $notification->save();
    return $notification;
  }
  public function sendEmailNotifications($users, $title, $msj, $type )
  {
    $users = User::find($users);
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
    Notification::send($users,new Notifier($details));
  }
}
