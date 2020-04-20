<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
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
    }
}
