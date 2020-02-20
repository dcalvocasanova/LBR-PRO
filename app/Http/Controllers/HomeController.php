<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'greeting' => 'Hola Artisan',
            'body' => 'Tienes una notificación, pendiente para revisar ',
            'thanks' => 'Esperamos pronto recibir su visita',
            'actionText' => 'Ver notificación',
            'actionURL' => url('/notificacion/opa'),
            'msg' => 'Hello tienes un nuevo mensaje que responder'
        ];

        //Notification::send($user, new Notifier($details)); //send several UserSystemComponent
        $user->notify(new Notifier($details)); // notify an particulary user

        dd('done');
    }
}
