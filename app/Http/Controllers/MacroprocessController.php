<?php
namespace App\Http\Controllers;
use DB;
use Mail;
use App\Macroprocess;
use App\Mail\EmailMessage;
use Illuminate\Support\Str;
use App\Imports\MacroprocessesImport;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
//use Spatie\Permission\Models\Role;
use App\Http\Requests\MacroprocessRequest;
use App\Exports\MacroprocessesTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Intervention\Image\Facades\Image as Image;

class MacroprocessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $macroprocesses = Macroprocess::paginate(5);
        return $macroprocesses;
    }

    /**
     * Get all users according to a type (system or web)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getMacroprocess()
    {
      $macroprocesss = Macroprocess::paginate(5);
      return $macroprocesss;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MacroprocessRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MacroprocessRequest $request)
    {
      $macroprocess = Macroprocess::create($request->all());
      //$randomPass = '123456';//Str::random(8);
      // $macroprocess->password =Hash::make($randomPass);
	  $macroprocess->save();
      if($macroprocess->save()){//  $this->sendPassword($randomPass, $email,$nombre);
      }
      //if(isset($request->role)){
      //    $macroprocess->assignRole($request->role);
      //}else{
      //    $macroprocess->givePermissionTo('simple_user');
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
      $macroprocess = Macroprocess::findOrFail($request->id);
      return $macroprocess;
    }

    /**
     * Display the current user
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function getCurrentMacroprocess()
    {
      $macroprocess = Macroprocess::findOrFail($request->id);
      return $macroprocess;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRole(Request $request)
    {
      $macroprocess = Macroprocess::findOrFail($request->id);
      $role = $macroprocess->getRoleNames();
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
      $macroprocess = Macroprocess::findOrFail($request->id);
      $macroprocess->update($request->all());
      //if(isset($request->role)){
        //  $macroprocess->roles()->detach();
          //$macroprocess->assignRole($request->role);
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
      $macroprocess = Macroprocess::findOrFail($request->id);
      //$macroprocess->roles()->detach();
      //$macroprocess->permissions()->detach();
      $macroprocess->delete();
    }

    /**
     * Get the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(){
        if ($search = \Request::get('q')) {
          $macroprocesss = Macroprocess::where(function($query) use ($search){
            $query
              ->where('macroprocess','LIKE',"%$search%")
              ->orWhere('input','LIKE',"%$search%")
              ->orWhere('provider','LIKE',"%$search%")
              ->orWhere('activity','LIKE',"%$search%")
              ->orWhere('responsible','LIKE',"%$search%")
              ->orWhere('process','LIKE',"%$search%")
              ->orWhere('user','LIKE',"%$search%")
			  ->orWhere('risk','LIKE',"%$search%")
			  ->orWhere('indicator','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $macroprocesss = Macroprocess::latest()->paginate(5);
        }
        return $macroprocesss;
    }

    /**
     * Update user password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function savePassword (Request $request)
    {
      $macroprocess = Macroprocess::findOrFail($request->id);
      $macroprocess->password =Hash::make($request->password);
      //pendiente enviar un correo confirmando el cambio de contraseña
      $macroprocess->save();
    }
    /**
     * Update user avatar
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveAvatar (Request $request)
    {
      $macroprocess = Macroprocess::findOrFail($request->id);
      $current_avatar = $macroprocess->avatar;
      if($request->avatar != $current_avatar){
        $file_avatar = time().'.' . explode('/', explode(':', substr($request->avatar, 0, strpos($request->avatar, ';')))[1])[1];
        $img = Image::make($request->avatar)->save(public_path('img/profile-usr/').$file_avatar);
        $macroprocess->avatar = $file_avatar;
        $last_avatar = public_path('img/profile-usr/').$current_avatar;
        if($last_avatar !=='default.png'){
            @unlink($last_avatar);
        }
      }
      $macroprocess->save();
    }
    /**
     * Get unread user's notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function unreadNotifications()
    {
      //$macroprocess = Auth::user();
      //return $macroprocess->unreadNotifications;
    }

    /**
     * Get all user's notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function allNotifications()
    {
      //$macroprocess = Auth::user();
      //return $macroprocess->notifications;
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
		//$request= request();
        
        //$filename= 'macroprocess'.'.xls';
        //$download_path= $filename;
       // $ret= \Excel::download(new MacroprocessesTemplateExport, $download_path);
        //\Log::info($ret);
        //$headers = ['Content-Type: application/xls','Content-Disposition: attachment; filename={$ret}'];

       // return response($download_path, 200,$headers);
		
		
		return Excel::download(new MacroprocessesTemplateExport, 'users.xls', \Maatwebsite\Excel\Excel::XLS);
    }

	  public function loadMacroprocess(Request $request){

		//$fileName = 'archivo'.'.'.$request->file->getClientOriginalExtension();

		//$file = $request->file('file');
		//$file= $fileName;
    //  return $request->file('archivo')->getClientOriginalName();
    $datos = Excel::import(new MacroprocessesImport, $request->file('archivo'));

  //  return $datos->failures();

		//Excel::import(new MacroprocesssImport, $request->file('archivo'));
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
