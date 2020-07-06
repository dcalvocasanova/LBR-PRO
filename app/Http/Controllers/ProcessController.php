<?php
namespace App\Http\Controllers;
use DB;
use Mail;
use App\Process;
use App\Mail\EmailMessage;
use Illuminate\Support\Str;
use App\Imports\ProcessImport;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
//use Spatie\Permission\Models\Role;
use App\Http\Requests\ProcessRequest;
use App\Exports\ProcesssTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Intervention\Image\Facades\Image as Image;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $processes = Process::paginate(5);
        return $processes;
    }

    /**
     * Get all users according to a type (system or web)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProcess()
    {
      $process = Process::paginate(5);
      return $process;
    }
	
	public function getProcessFile(Request $request)
    {
      $macroprocess = Process::select('relatedToLevel','file','subprocessProduct')->where('project_id', $request->id)->get();
      return $macroprocess;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProcessRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProcessRequest $request)
    {
      $process = Process::create($request->all());
      //$randomPass = '123456';//Str::random(8);
      // $process->password =Hash::make($randomPass);
	  $process->save();
      if($process->save()){//  $this->sendPassword($randomPass, $email,$nombre);
      }
      //if(isset($request->role)){
      //    $process->assignRole($request->role);
      //}else{
      //    $process->givePermissionTo('simple_user');
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
      $process = Process::findOrFail($request->id);
      return $process;
    }

    /**
     * Display the current user
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function getCurrentProcess()
    {
      $process = Process::where('project_id',$request->id )->get();
      return $process;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRole(Request $request)
    {
      $process = Process::findOrFail($request->id);
      $role = $process->getRoleNames();
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
      $process = Process::findOrFail($request->id);
      $process->update($request->all());
      //if(isset($request->role)){
        //  $process->roles()->detach();
          //$process->assignRole($request->role);
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
      $process = Process::findOrFail($request->id);
      //$process->roles()->detach();
      //$process->permissions()->detach();
      $process->delete();
    }

    /**
     * Get the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(){
        if ($search = \Request::get('q')) {
          $processs = Process::where(function($query) use ($search){
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
            $processs = Process::latest()->paginate(5);
        }
        return $processs;
    }

    /**
     * Update user password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function savePassword (Request $request)
    {
      $process = Process::findOrFail($request->id);
      $process->password =Hash::make($request->password);
      //pendiente enviar un correo confirmando el cambio de contraseña
      $process->save();
    }
    /**
     * Update user avatar
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveAvatar (Request $request)
    {
      $process = Process::findOrFail($request->id);
      $current_avatar = $process->avatar;
      if($request->avatar != $current_avatar){
        $file_avatar = time().'.' . explode('/', explode(':', substr($request->avatar, 0, strpos($request->avatar, ';')))[1])[1];
        $img = Image::make($request->avatar)->save(public_path('img/profile-usr/').$file_avatar);
        $process->avatar = $file_avatar;
        $last_avatar = public_path('img/profile-usr/').$current_avatar;
        if($last_avatar !=='default.png'){
            @unlink($last_avatar);
        }
      }
      $process->save();
    }
    /**
     * Get unread user's notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function unreadNotifications()
    {
      //$process = Auth::user();
      //return $process->unreadNotifications;
    }

    /**
     * Get all user's notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function allNotifications()
    {
      //$process = Auth::user();
      //return $process->notifications;
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
      return Excel::download(new ProcesssTemplateExport, 'users.xls', \Maatwebsite\Excel\Excel::XLS);
    }

	  public function loadProcesss(Request $request){

		//$fileName = 'archivo'.'.'.$request->file->getClientOriginalExtension();

		//$file = $request->file('file');
		//$file= $fileName;
    //  return $request->file('archivo')->getClientOriginalName();
    $datos = Excel::import(new MacroprocesssImport, $request->file('archivo'));

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
