<?php

namespace App\Http\Controllers;

use App\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $parameters = Parameter::latest()->paginate(5);
      return $parameters;
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
      $parameter = new Parameter();
      $parameter->name = $request->nombre;
      $parameter->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request  $request)
    {
      $parameter = Parameter::findOrFail($request->id);
      return $parameter;
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

      $parameter = Parameter::findOrFail($request->id);
      $parameter->name = $request->nombre;
      $parameter->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
      $parameter = Parameter::destroy($request->id);
      return $parameter;
    }

    /**
     * Save session resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function session(Request  $request)
    {
      $request->session()->put('parameter_id', $request->id);
      $request->session()->put('parameter_name', $request->name);
    }
}
