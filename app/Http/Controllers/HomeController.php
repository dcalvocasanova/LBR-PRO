<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Notifier;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function sendNotification()
    {
        $user = Auth::user();

        $details = [
            'greeting' => 'Un saludo cordial',
            'msg' => 'Aprobar objetivos',
            'body' => 'Tienes una notificación, pendiente para revisar ',
            'thanks' => 'Esperamos pronto recibir su visita',
            'actionText' => 'Ir al sitio web',
            'actionURL' => url('/notificaciones'),
        ];
        //Notification::send($user, new Notifier($details)); //send several UserSystemComponent
        $user->notify(new Notifier($details)); // notify an particulary user
        dd('done');
    }

    public function sendNoti(Request $request)
    {
        $usuarios = $request->usersToNotify;
        $users = User::find($usuarios);

        $details = [
            'greeting' => 'Un saludo cordial',
            'msg' => $request->msg,
            'body' => $request->body,
            'sender' => Auth::user(),
            'thanks' => 'Esperamos pronto de el visto bueno',
            'actionText' => 'Ir al sitio web',
            'actionURL' => url('/notificaciones'),
        ];      
        Notification::send($users, new Notifier($details)); //send several UserSystemComponent

      //  $user->notify(new Notifier($details)); // notify an particulary user

    }
}
