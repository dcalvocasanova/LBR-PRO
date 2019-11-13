<?php

namespace App\Http\Controllers;

use App\Variable;
use Illuminate\Http\Request;

class VariableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if ($request->session()->exists('subparameter_id')) {
        $variables = Variable::where('subparameter_id',$request->session()->get('subparameter_id'))->paginate(5);
        return $variables;
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
      $variable = new Variable();
      $variable->name = $request->nombre;
      $variable->type = $request->tipo;
      $variable->subparameter_id = $request->session()->get('subparameter_id');
      $variable->value = isset($request->valor)? $request->valor:"0";
      $variable->measure = isset($request->medida)? $request->medida:"NA";
      $variable->rule = isset($request->regla)? $request->regla:"NA";
      $variable->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request  $request)
    {
      $variable = Variable::findOrFail($request->id);
      return $variable;
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

      $variable = Variable::findOrFail($request->id);
      $variable->name = $request->nombre;
      $variable->type = $request->tipo;
      $variable->subparameter_id = $request->session()->get('subparameter_id');
      $variable->value = isset($request->valor)? $request->valor:"0";
      $variable->measure = isset($request->medida)? $request->medida:"NA";
      $variable->rule = isset($request->regla)? $request->regla:"NA";
      $variable->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
      $variable = Variable::destroy($request->id);
      return $variable;
    }
}
