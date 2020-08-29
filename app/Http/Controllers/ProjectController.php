<?php

namespace App\Http\Controllers;

use App\Project;
use App\Subprocess;
use App\Process;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image as Image;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $projects = Project::paginate(5);
      return $projects;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllProjects()
    {
      if(Auth::user()->relatedProjects > 0 ){
        $projects = Project::where('id',Auth::user()->relatedProjects)->select('id','name')->get();
        return $projects;
      }else{
        $projects = Project::all('id','name');
        return $projects;
      }
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
            'name' => 'required|string|max:100'
      ]);
      $project = new Project();
      $project->name = $request->name;

      if(isset($request->logo_project)){
          $file_logo_project = time().'.' . explode('/', explode(':', substr($request->logo_project, 0, strpos($request->logo_project, ';')))[1])[1];
          $img = Image::make($request->logo_project)->save(public_path('img/profile-prj/').$file_logo_project);
          $img->fit(75, 75, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
          });
          $request->logo_project = $file_logo_project;
      }
      $project->logo_project = isset($request->logo_project)? $request->logo_project:"default.png";

      if(isset($request->logo_sponsor)){
          $file_logo_sponsor = time().'.' . explode('/', explode(':', substr($request->logo_sponsor, 0, strpos($request->logo_sponsor, ';')))[1])[1];
          $img = Image::make($request->logo_sponsor)->save(public_path('img/profile-prj/').$file_logo_sponsor);
          $img->fit(75, 75, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
          });
          $request->logo_sponsor = $file_logo_sponsor;
      }
      $project->logo_sponsor = isset($request->logo_sponsor)? $request->logo_sponsor:"default.png";

      if(isset($request->logo_auxiliar)){
          $file_logo_auxiliar = time().'.' . explode('/', explode(':', substr($request->logo_auxiliar, 0, strpos($request->logo_auxiliar, ';')))[1])[1];
          $img = Image::make($request->logo_auxiliar)->save(public_path('img/profile-prj/').$file_logo_auxiliar);
          $img->fit(75, 75, function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
          });
          $request->logo_auxiliar = $file_logo_auxiliar;
      }
      $project->logo_auxiliar = isset($request->logo_auxiliar)? $request->logo_auxiliar:"default.png";

      if(isset($request->terms_connditions)){
        $file64_current_terms_connditions = substr($request->terms_connditions, strpos($request->terms_connditions, ',') + 1);
        $file = base64_decode($file64_current_terms_connditions);
        $fileName ='terms'.time().'.pdf';
        Storage::put('public/docs/'.$fileName, $file);
        $request->terms_connditions = $fileName;
      }
      $project->terms_connditions = isset($request->terms_connditions)? $request->terms_connditions:"default.pdf";

      $project->longitude = isset($request->longitud)? $request->longitud:"0,0";
      $project->latitude = isset($request->latitud)? $request->latitud:"0,0";
      $project->economic_activity = isset($request->actividad_economica)? $request->actividad_economica:"Sin fines de lucro";
      $project->save();
      return $project;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $project = Project::findOrFail($request->id);
      return $project;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $this->validate($request,[
            'name' => 'required|string|max:100'
      ]);

      $project = Project::findOrFail($request->id);

      /*get old-data*/
      $current_logo_project = $project->logo_project;
      $current_logo_sponsor = $project->logo_sponsor;
      $current_logo_auxiliar = $project->logo_auxiliar;
      $current_terms_connditions = $project->terms_connditions;
      $project->name = $request->name;

      if($request->logo_project != $current_logo_project)
      {
        $file_logo_project = time().'.' . explode('/', explode(':', substr($request->logo_project, 0, strpos($request->logo_project, ';')))[1])[1];
        $img = $img = Image::make($request->logo_project)->save(public_path('img/profile-prj/').$file_logo_project);
        $img->fit(75, 75, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $project->logo_project = $file_logo_project;
        $last_logo_project = public_path('img/profile-prj/').$current_logo_project;
        if(file_exists($last_logo_project) && $current_logo_project !='default.png' ){
                @unlink($last_logo_project);
        }
      }

      if($request->logo_sponsor != $current_logo_sponsor)
      {
        $file_logo_sponsor = time().'.' . explode('/', explode(':', substr($request->logo_sponsor, 0, strpos($request->logo_sponsor, ';')))[1])[1];
        $img = Image::make($request->logo_sponsor)->save(public_path('img/profile-prj/').$file_logo_sponsor);
        $img->fit(75, 75, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $project->logo_sponsor = $file_logo_sponsor;
        $last_logo_sponsore = public_path('img/profile-prj/').$current_logo_sponsor;
        if(file_exists($last_logo_sponsore) && $current_logo_sponsor !='default.png' ){
                @unlink($last_logo_sponsore);
        }
      }

      if($request->logo_auxiliar != $current_logo_auxiliar)
      {
        $file_logo_auxiliar = time().'.' . explode('/', explode(':', substr($request->logo_auxiliar, 0, strpos($request->logo_auxiliar, ';')))[1])[1];
        $img = Image::make($request->logo_auxiliar)->save(public_path('img/profile-prj/').$file_logo_auxiliar);
        $img->fit(75, 75, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $project->logo_auxiliar = $file_logo_auxiliar;
        $last_logo_auxiliar = public_path('img/profile-prj/').$current_logo_auxiliar;
        if(file_exists($last_logo_auxiliar) && $current_logo_auxiliar !='default.png' ){
                @unlink($last_logo_auxiliar);
        }
      }

      if($request->terms_connditions != $current_terms_connditions){
        $file64_current_terms_connditions = substr($request->terms_connditions, strpos($request->terms_connditions, ',') + 1);
        $file = base64_decode($file64_current_terms_connditions);
        $fileName ='terms'.time().'.pdf';
        Storage::put('public/docs/'.$fileName, $file);
        $request->terms_connditions = $fileName;
      }
      $project->terms_connditions = isset($request->terms_connditions)? $request->terms_connditions:"default.pdf";


      if (isset($request->ubicacion))
      {
        $project->location = $request->ubicacion;
      }

      if (isset($request->actividad_economica))
      {
        $project->economic_activity = $request->actividad_economica;
      }


      $project->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
      $project = Project::destroy($request->id);
      return $project;
    }

    /**
     * Get the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(){
        if ($search = \Request::get('q')) {
            $proyects = Project::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('description','LIKE',"%$search%");
            })->paginate(30);
        }else{
            $proyects = Project::latest()->paginate(5);
        }
        return $proyects;
    }

    /**
     * Get all products related to a project
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProducts(Request  $request){
      $project_id = $request->id;
      $p_process = Process::where('project_id',$request->id)->where('subprocessProduct','producto')->get();
      $p_subprocess = Subprocess::where('project_id',$request->id)->get();
      return ['process'=> $p_process , 'subprocess'=>$p_subprocess];
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCurrentProjectSession()
    {
      $session_project = session('currentProject_id');
      if (!isset($session_project)) {
        if(Auth::user()->relatedProjects > 0 ){
            session()->put('currentProject_id', Auth::user()->relatedProjects);
        }else{
          $project = Project::latest()->first();
          session()->put('currentProject_id', $project->id);
        }

      }
      return ['id'=> session('currentProject_id')];
    }

    public function getCurrentProjectTerms()
    {
      if(Auth::user()->relatedProjects > 0 ){
        $project = Project::find(Auth::user()->relatedProjects);
        $route = asset('storage/docs/'.$project->terms_connditions);
        return  ['id'=> 1, 'terms' => $route];
      }else{
        return  ['id'=> -1];
      }
    }

    /**
     * Save session resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function setCurrentProjectSession(Request  $request)
    {
      session()->put('currentProject_id', $request->id);
      return ['id'=> session('currentProject_id')];
    }

}
