<?php

namespace App\Http\Controllers;

use App\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->session()->exists('macroprocess_id')) {
      $levels = Level::where('macroprocess_id',$request->session()->get('macroprocess_id'))->paginate(5);
      return $levels;
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
    $level = new Level();
    $level->name = $request->nombre;
    $level->macroprocess_id = $request->session()->get('macroprocess_id');
    $level->save();
  }

  /**
   * Display the specified resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function show(Request  $request)
  {
    $level = Level::findOrFail($request->id);
    return $level;
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

    $level = Level::findOrFail($request->id);
    $level->name = $request->nombre;
    $level->save();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request  $request)
  {
    $level = Level::destroy($request->id);
    return $level;
  }

  /**
   * Save session resource from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function session(Request  $request)
  {
    $request->session()->put('level_id', $request->id);
    $request->session()->put('level_name', $request->name);
    return $request->session()->all();
  }
}
