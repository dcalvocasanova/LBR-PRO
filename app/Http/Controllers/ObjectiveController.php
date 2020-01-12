<?php

namespace App\Http\Controllers;

use App\Objective;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if ($request->session()->exists('level_id')) {
        $objectives = Variable::where('level_id',$request->session()->get('level_id'))->paginate(5);
        return $objectives;
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
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|string|max:100'
      ]);
      $objective = new Variable();
      $objective->name = $request->nombre;
      $objective->type = $request->tipo;
      $objective->level_id = $request->session()->get('level_id');
      $objective->value = isset($request->valor)? $request->valor:"0";
      $objective->measure = isset($request->medida)? $request->medida:"NA";
      $objective->rule = isset($request->regla)? $request->regla:"NA";
      $objective->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request  $request)
    {
      $objective = Variable::findOrFail($request->id);
      return $objective;
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
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|string|max:100'
      ]);

      $objective = Variable::findOrFail($request->id);
      $objective->name = $request->nombre;
      $objective->type = $request->tipo;
      $objective->level_id = $request->session()->get('level_id');
      $objective->value = isset($request->valor)? $request->valor:"0";
      $objective->measure = isset($request->medida)? $request->medida:"NA";
      $objective->rule = isset($request->regla)? $request->regla:"NA";
      $objective->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
      $objective = Variable::destroy($request->id);
      return $objective;
    }
}
