<?php
namespace App\Http\Controllers;
use DB;
use Mail;
use App\User;
use App\Mail\EmailMessage;
use Illuminate\Support\Str;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use App\Exports\UsersTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\userRegisterNotificator;

use Intervention\Image\Facades\Image as Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->where('type','web')->latest()->paginate(5);
        return $users;
    }

    /**
     * Get all users according to a type (system or web)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUserSystem()
    {
      $users = User::with('roles')->where('type','sys')->latest()->paginate(5);
      return $users;
    }

    /**
     * Get all users according to a related project
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUserByProject(Request $request)
    {
      $users = User::with('roles')->where('relatedProjects',$request->project)->latest()->paginate(5);
      return $users;
    }

    /**
     * Get all users according to a related level structure
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUserByLevelStructure(Request $request)
    {
      $users = User::with('roles')->where('relatedLevel',$request->level)->latest()->paginate(10);
      return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
      $user = User::create($request->all());
      $randomPass = Str::random(8);
      $user->password =Hash::make($randomPass);
      if($user->save()){
        $details = [
            'usuario' => 'Un saludo cordial '.$user->name,
            'password' => 'La contraseña temporal es: '.$randomPass
        ];
        Notification::send($user, new userRegisterNotificator($details)); //send several UserSystemComponent
      }
      if(isset($request->role)){
          $user->assignRole($request->role);
      }else{
          $user->givePermissionTo('simple_user');
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
     * Display the current user
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function getCurrentUser()
    {
      $user = Auth::user();
      return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRole(Request $request)
    {
      $user = User::findOrFail($request->id);
      $role = $user->getRoleNames();
      return $role[0];
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUserRoles (Request $request)
    {
      $users = User::find($request->users);
      foreach ($users as $user) {
        $user->roles()->detach();
        if($request->role == 'remove'){
          $user->givePermissionTo('simple_user');
        }else{
          $user->assignRole($request->role);
        }
      }
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
      $user->update($request->all());
      if(isset($request->role)){
          $user->roles()->detach();
          $user->assignRole($request->role);
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $user = User::findOrFail($request->id);
      $user->roles()->detach();
      $user->permissions()->detach();
      $user->delete();
    }

    /**
     * Get the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(){
        if ($search = \Request::get('q')) {
          $users = User::where(function($query) use ($search){
            $query
              ->where('type','web')
              ->orWhere('name','LIKE',"%$search%")
              ->orWhere('identification','LIKE',"%$search%")
              ->orWhere('email','LIKE',"%$search%")
              ->orWhere('gender','LIKE',"%$search%")
              ->orWhere('sex','LIKE',"%$search%")
              ->orWhere('position','LIKE',"%$search%")
              ->orWhere('ethnic','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $users = User::where('type','web')->latest()->paginate(5);
        }
        return $users;
    }

    /**
     * Update user password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function savePassword (Request $request)
    {
      $user = User::findOrFail($request->id);
      $user->password =Hash::make($request->password);
      //pendiente enviar un correo confirmando el cambio de contraseña
      $user->save();
    }
    /**
     * Update user avatar
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveAvatar (Request $request)
    {
      $user = User::findOrFail($request->id);
      $current_avatar = $user->avatar;
      if($request->avatar != $current_avatar){
        $file_avatar = time().'.' . explode('/', explode(':', substr($request->avatar, 0, strpos($request->avatar, ';')))[1])[1];
        $img = Image::make($request->avatar)->save(public_path('img/profile-usr/').$file_avatar);
        $user->avatar = $file_avatar;
        $last_avatar = public_path('img/profile-usr/').$current_avatar;
        if($last_avatar !=='default.png'){
            @unlink($last_avatar);
        }
      }
      $user->save();
    }
    /**
     * Get unread user's notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function unreadNotifications()
    {
      $user = Auth::user();
      return $user->unreadNotifications;
    }

    /**
     * Get all user's notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function allNotifications()
    {
      $user = Auth::user();
      return $user->notifications;
    }

    /**
     * Get Excel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getExcel()
    {
      return Excel::download(new UsersTemplateExport, 'users.xls', \Maatwebsite\Excel\Excel::XLS);
    }

	  public function loadUsers(Request $request){

    $datos = Excel::import(new UsersImport, $request->file('archivo'));
		$file =  $request->file('archivo');
        if(!empty($file)){
          $fileName = rand().'.'.$file->getClientOriginalExtension();
          $request->file('archivo')->move(public_path('upload'), $fileName);
          return response()->json(['success'=>'You have successfully upload file.']);
        }
        return response()->json(['fail'=>'No envió nada.']);
	}
}
