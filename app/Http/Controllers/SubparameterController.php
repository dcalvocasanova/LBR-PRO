<?php

namespace App\Http\Controllers;

use App\Subparameter;
use Illuminate\Http\Request;

class SubparameterController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->session()->exists('parameter_id')) {
      $subparameters = Subparameter::where('parameter_id',$request->session()->get('parameter_id'))->paginate(5);
      return $subparameters;
    }
    return "";
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
          'nombre' => 'required|string|max:100'
    ]);
    $subparameter = new Subparameter();
    $subparameter->name = $request->nombre;
    $subparameter->parameter_id = $request->session()->get('parameter_id');
    $subparameter->save();
  }

  /**
   * Display the specified resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function show(Request  $request)
  {
    $subparameter = Subparameter::findOrFail($request->id);
    return $subparameter;
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
          'nombre' => 'required|string|max:100'
    ]);

    $subparameter = Subparameter::findOrFail($request->id);
    $subparameter->name = $request->nombre;
    $subparameter->save();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request  $request)
  {
    $subparameter = Subparameter::destroy($request->id);
    return $subparameter;
  }

  /**
   * Save session resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function session(Request  $request)
  {
    $request->session()->put('subparameter_id', $request->id);
    $request->session()->put('subparameter_name', $request->name);
    return $request->session()->all();
  }
}
