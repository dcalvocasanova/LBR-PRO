<?php

namespace App\Http\Controllers;
use App\Macroprocess;
use Illuminate\Http\Request;

class MacroprocessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $macroprocesss = Macroprocess::latest()->paginate(5);
      return $macroprocesss;
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
      $macroprocess = new Macroprocess();
      $macroprocess->name = $request->nombre;
      $macroprocess->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request  $request)
    {
      $macroprocess = Macroprocess::findOrFail($request->id);
      return $macroprocess;
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

      $macroprocess = Macroprocess::findOrFail($request->id);
      $macroprocess->name = $request->nombre;
      $macroprocess->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
      $macroprocess = Macroprocess::destroy($request->id);
      return $macroprocess;
    }

    /**
     * Save session resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function session(Request  $request)
    {
      $request->session()->put('macroprocess_id', $request->id);
      $request->session()->put('macroprocess_name', $request->name);
    }
}
