<?php

namespace App\Http\Controllers;

use App\PsychosocialVariable;
use Illuminate\Http\Request;

class PsychosocialVariableController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $psychosocialVariables = PsychosocialVariable::paginate(10);
    return $psychosocialVariables;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $psychosocialVariable = PsychosocialVariable::create($request->all());
  }

  /**
   * Display the specified resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request)
  {
    $psychosocialVariable = PsychosocialVariable::findOrFail($request->id);
    return $psychosocialVariable;
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $psychosocialVariable = PsychosocialVariable::findOrFail($request->id);
    $psychosocialVariable->update($request->all());
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
     $psychosocialVariable = PsychosocialVariable::destroy($request->id);
  }

  /**
   * Get the specified resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function search(){
      if ($search = \Request::get('q')) {
          $psychosocialVariables = PsychosocialVariable::where(function($query) use ($search){
              $query->where('variable','LIKE',"%$search%");
          })->paginate(10);
      }else{
          $psychosocialVariables = Project::PsychosocialVariable()->paginate(10);
      }
      return $psychosocialVariables;
  }
}
