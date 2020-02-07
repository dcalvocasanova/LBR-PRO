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
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
      $user = User::create($request->all());
      $randomPass = '123456';//Str::random(8);
      $user->password =Hash::make($randomPass);
      if($user->save()){//  $this->sendPassword($randomPass, $email,$nombre);
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
    public function update(Request $request)
    {
      $user = User::findOrFail($request->id);
      $user->update($request->all());
      $user->roles()->detach();
      if(isset($request->role)){
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
              ->where('name','LIKE',"%$search%")
              ->orWhere('identification','LIKE',"%$search%")
              ->orWhere('email','LIKE',"%$search%")
              ->orWhere('gender','LIKE',"%$search%")
              ->orWhere('sex','LIKE',"%$search%")
              ->orWhere('position','LIKE',"%$search%")
              ->orWhere('ethnic','LIKE',"%$search%");
            })->paginate(10);
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

    /**
     * Update user profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile (Request $request)
    {
      $this->validate($request,['password' => 'required']);
      $user = User::findOrFail($request->id);
      $current_avatar = $user->avatar;
      $user->password =Hash::make($randomPass);
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
      }
      $user->save();
    }

    /**
     * Send Password
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function sendPassword($randomPass, $email, $nombre)
    {
      $message = ' contraseña temporal '.$randomPass;
      $for = $email;
        Mail::to($for)->send(new EmailMessage($nombre, $message));
        return redirect()->back();
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

		//$fileName = 'archivo'.'.'.$request->file->getClientOriginalExtension();

		//$file = $request->file('file');
		//$file= $fileName;
    //  return $request->file('archivo')->getClientOriginalName();
    $datos = Excel::import(new UsersImport, $request->file('archivo'));

  //  return $datos->failures();

		//Excel::import(new UsersImport, $request->file('archivo'));
		//dd($request);
		//dd($request->users);
		//$file = $request->file('users');


    //$file->getRealPath();
    //$file->getClientOriginalName();
    /*$file->getClientOriginalExtension();
    $file->getSize();
    $file->getMimeType();*/
		//return response()->json(['success'=>'You have successfully upload file'. $file]);


		$file =  $request->file('archivo');
        if(!empty($file)){
          $fileName = rand().'.'.$file->getClientOriginalExtension();
          $request->file('archivo')->move(public_path('upload'), $fileName);
          return response()->json(['success'=>'You have successfully upload file.']);
        }
        return response()->json(['fail'=>'Mamo, no envió nada.']);
	}
}
