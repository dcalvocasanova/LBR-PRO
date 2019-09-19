<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
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
      $projects = Project::all();
      return $projects;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
          Image::make($request->logo_project)->save(public_path('img/profile-prj/').$file_logo_project);
          $request->logo_project = $file_logo_project;
      }
      $project->logo_project = isset($request->logo_project)? $request->logo_project:"default.png";

      if(isset($request->logo_sponsor)){
          $file_logo_sponsor = time().'.' . explode('/', explode(':', substr($request->logo_sponsor, 0, strpos($request->logo_sponsor, ';')))[1])[1];
          Image::make($request->logo_sponsor)->save(public_path('img/profile-prj/').$file_logo_sponsor);
          $request->logo_sponsor = $file_logo_sponsor;
      }
      $project->logo_sponsor = isset($request->logo_sponsor)? $request->logo_sponsor:"default.png";

      if(isset($request->logo_auxiliar)){
          $file_logo_auxiliar = time().'.' . explode('/', explode(':', substr($request->logo_auxiliar, 0, strpos($request->logo_auxiliar, ';')))[1])[1];
          Image::make($request->logo_auxiliar)->save(public_path('img/profile-prj/').$file_logo_auxiliar);
          $request->logo_project = $file_logo_project;
      }
      $project->logo_auxiliar = isset($request->logo_auxiliar)? $request->logo_auxiliar:"default.png";

      $project->description = isset($request->description)? $request->description:"Proyecto carga de trabajo para ". $request->name;
      $project->save();
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
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

      $project->name = $request->name;

      if($request->logo_project != $current_logo_project)
      {
        $file_logo_project = time().'.' . explode('/', explode(':', substr($request->logo_project, 0, strpos($request->logo_project, ';')))[1])[1];
        Image::make($request->logo_project)->save(public_path('img/profile-prj/').$file_logo_project);
        $request->merge(['logo_project' => $file_logo_project]);
        $project->logo_project = $file_logo_project;
        $last_logo_project = public_path('img/profile-prj/').$current_logo_project;
        if(file_exists($last_logo_project) && $current_logo_project !='default.png' ){
                @unlink($last_logo_project);
        }
      }

      if($request->logo_sponsor != $current_logo_sponsor)
      {
        $file_logo_sponsor = time().'.' . explode('/', explode(':', substr($request->logo_sponsor, 0, strpos($request->logo_sponsor, ';')))[1])[1];
        Image::make($request->logo_sponsor)->save(public_path('img/profile-prj/').$file_logo_sponsor);
        $project->logo_sponsor = $file_logo_sponsor;
        $last_logo_sponsore = public_path('img/profile-prj/').$current_logo_sponsor;
        if(file_exists($last_logo_sponsore) && $current_logo_sponsor !='default.png' ){
                @unlink($last_logo_sponsore);
        }
      }

      if($request->logo_auxiliar != $current_logo_auxiliar)
      {
        $file_logo_auxiliar = time().'.' . explode('/', explode(':', substr($request->logo_auxiliar, 0, strpos($request->logo_auxiliar, ';')))[1])[1];
        Image::make($request->logo_auxiliar)->save(public_path('img/profile-prj/').$file_logo_auxiliar);
        $project->logo_auxiliar = $file_logo_auxiliar;
        $last_logo_auxiliar = public_path('img/profile-prj/').$current_logo_auxiliar;
        if(file_exists($last_logo_auxiliar) && $current_logo_auxiliar !='default.png' ){
                @unlink($last_logo_auxiliar);
        }
      }

      if (!empty($project->description))
      {
        $project->description = $request->description;
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
     * @return \Illuminate\Http\Response
     */
    public function search(){
        if ($search = \Request::get('q')) {
            $proyects = Project::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('description','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $proyects = Project::latest()->paginate(5);
        }
        return $proyects;
    }
}
