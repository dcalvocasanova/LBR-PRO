<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Str;
use App\Mail\EmailMessage;
use Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(5);
        return $users;
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request,[
          'nombre' => 'required',
          'email' => 'required|email|unique:users',
          'identificacion' => 'required|string|unique:users,identification',
          'genero' => 'required|string',
          'sexo' => 'required|string',
          'fecha_nacimiento' => 'required|date',
          'salario'=> 'required|numeric',
          'fecha_ingreso'=> 'required|string',
          'puesto'=> 'required|string',
          'etnia' => 'required|string'
      ]);

      $user = new User();
      $user->name = $request->nombre;
      $nombre = $request->nombre;
      $user->identification = $request->identificacion;
      $email = $request->email;
      $user->email = $request->email;
      $user->type = isset($request->tipo)? $request->tipo:"usuario";
      $user->gender = $request->genero;
      $user->sex = $request->sexo;
      $user->ethnic = $request->etnia;
      $user->position= $request->puesto;
      $user->salary= $request->salario;
      $user->birthday= $request->fecha_nacimiento;
      $user->workingsince= $request->fecha_ingreso;
      $randomPass = Str::random(8);
      $user->password =Hash::make($randomPass);
      $user->avatar = "default.png";
      if($user->save()){
        $this->sendPassword($randomPass, $email,$nombre);
      }

    }
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $user = User::findOrFail($request->id);
      return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $user = User::findOrFail($request->id);
      if($user->identification !=  $request->identificacion){
        $this->validate($request,['identificacion' => 'string|max:50|unique:users,identification']);
      }
      if( $user->email !=  $request->email ){
          $this->validate($request,['email' => 'string|email|max:50|unique:users']);
      }
      $current_avatar = $user->avatar;
      $user->name = $request->nombre;
      $user->identification = $request->identificacion;
      $user->email = $request->email;
      $user->type = $request->tipo;
      $user->position= $request->puesto;
      $user->salary= $request->salario;
      $user->birthday= $request->fecha_nacimiento;
      $user->workingsince= $request->fecha_ingreso;
      $user->gender = $request->genero;
      $user->sex = $request->sexo;
      $user->ethnic = $request->etnia;
/*
      if($request->avatar != $current_avatar)
      {
        $file_avatar = time().'.' . explode('/', explode(':', substr($request->avatar, 0, strpos($request->avatar, ';')))[1])[1];
        $img = Image::make($request->avatar)->save(public_path('img/profile-usr/').$file_avatar);
        $img->fit(75, 75, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $user->avatar = $file_avatar;
        $last_avatar = public_path('img/profile-usr/').$current_avatar;
        if(file_exists($last_avatar) && $last_avatar !='default.png' ){
                @unlink($last_avatar);
        }
      }*/
      $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $user = User::destroy($request->id);
    }

    /**
     * Get the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(){
        if ($search = \Request::get('q')) {
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('identification','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%")
                        ->orWhere('gender','LIKE',"%$search%")
                        ->orWhere('sex','LIKE',"%$search%")
                        ->orWhere('position','LIKE',"%$search%")
                        ->orWhere('ethnic','LIKE',"%$search%");
            })->paginate(30);
        }else{
            $users = User::latest()->paginate(5);
        }
        return $users;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadAvatar(Request $request)
    {
      $imageName = time().'.'.$request->file->getClientOriginalExtension();
      $request->file->move(public_path('images'), $imageName);
    	return response()->json(['success'=>'You have successfully upload file.']);
    }


    public function sendPassword($randomPass, $email, $nombre)
    {
      $message = ' contraseña temporal '.$randomPass;
      $for = $email;
        Mail::to($for)->send(new EmailMessage($nombre, $message));

        return redirect()->back();
    }
}
