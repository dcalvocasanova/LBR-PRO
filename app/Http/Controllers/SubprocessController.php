<?php
namespace App\Http\Controllers;
use DB;
use Mail;
use App\Subprocess;
use App\Mail\EmailMessage;
use Illuminate\Support\Str;
use App\Imports\SubprocessImport;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
//use Spatie\Permission\Models\Role;
use App\Http\Requests\SubprocessRequest;
use App\Exports\SubprocesssTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Intervention\Image\Facades\Image as Image;

class SubprocessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subprocesses = Subprocess::paginate(5);
        return $subprocesses;
    }

    /**
     * Get all users according to a type (system or web)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSubprocess()
    {
      $subprocess = Subprocess::paginate(5);
      return $subprocess;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SubprocessRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubprocessRequest $request)
    {
      $subprocess = Subprocess::create($request->all());
      //$randomPass = '123456';//Str::random(8);
      // $subprocess->password =Hash::make($randomPass);
	  $subprocess->save();
      if($subprocess->save()){//  $this->sendPassword($randomPass, $email,$nombre);
      }
      //if(isset($request->role)){
      //    $subprocess->assignRole($request->role);
      //}else{
      //    $subprocess->givePermissionTo('simple_user');
      //}
    }
    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $subprocess = Subprocess::findOrFail($request->id);
      return $subprocess;
    }

    /**
     * Display the current user
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function getCurrentSubprocess(Request $request)
    {
      $subprocess = Subprocess::where('project_id',$request->id )->get();
      return $subprocess;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRole(Request $request)
    {
      $subprocess = Subprocess::findOrFail($request->id);
      $role = $subprocess->getRoleNames();
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
      $subprocess = Subprocess::findOrFail($request->id);
      $subprocess->update($request->all());
      //if(isset($request->role)){
        //  $subprocess->roles()->detach();
          //$subprocess->assignRole($request->role);
      //}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      $subprocess = Subprocess::findOrFail($request->id);
      //$subprocess->roles()->detach();
      //$subprocess->permissions()->detach();
      $subprocess->delete();
    }

    /**
     * Get the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(){
        if ($search = \Request::get('q')) {
          $subprocesss = Subprocess::where(function($query) use ($search){
            $query
              
              ->orWhere('input','LIKE',"%$search%")
              ->orWhere('provider','LIKE',"%$search%")
              ->orWhere('activity','LIKE',"%$search%")
              ->orWhere('responsible','LIKE',"%$search%")
              
              ->orWhere('user','LIKE',"%$search%")
			  ->orWhere('risk','LIKE',"%$search%")
			  ->orWhere('indicator','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $subprocesss = Subprocess::latest()->paginate(5);
        }
        return $subprocesss;
    }

    /**
     * Update user password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function savePassword (Request $request)
    {
      $subprocess = Subprocess::findOrFail($request->id);
      $subprocess->password =Hash::make($request->password);
      //pendiente enviar un correo confirmando el cambio de contraseña
      $subprocess->save();
    }
    /**
     * Update user avatar
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveAvatar (Request $request)
    {
      $subprocess = Subprocess::findOrFail($request->id);
      $current_avatar = $subprocess->avatar;
      if($request->avatar != $current_avatar){
        $file_avatar = time().'.' . explode('/', explode(':', substr($request->avatar, 0, strpos($request->avatar, ';')))[1])[1];
        $img = Image::make($request->avatar)->save(public_path('img/profile-usr/').$file_avatar);
        $subprocess->avatar = $file_avatar;
        $last_avatar = public_path('img/profile-usr/').$current_avatar;
        if($last_avatar !=='default.png'){
            @unlink($last_avatar);
        }
      }
      $subprocess->save();
    }
    /**
     * Get unread user's notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function unreadNotifications()
    {
      //$subprocess = Auth::user();
      //return $subprocess->unreadNotifications;
    }

    /**
     * Get all user's notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function allNotifications()
    {
      //$subprocess = Auth::user();
      //return $subprocess->notifications;
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
      return Excel::download(new SubprocesssTemplateExport, 'users.xls', \Maatwebsite\Excel\Excel::XLS);
    }

	  public function loadSubprocesss(Request $request){

		//$fileName = 'archivo'.'.'.$request->file->getClientOriginalExtension();

		//$file = $request->file('file');
		//$file= $fileName;
    //  return $request->file('archivo')->getClientOriginalName();
    $datos = Excel::import(new MacrosubprocesssImport, $request->file('archivo'));

  //  return $datos->failures();

		//Excel::import(new MacrosubprocesssImport, $request->file('archivo'));
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
