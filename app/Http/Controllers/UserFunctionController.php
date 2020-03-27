<?php

namespace App\Http\Controllers;

use App\UserFunction;
use Illuminate\Http\Request;
use App\Http\Requests\UserFunctionRequest;

class UserFunctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserFunctionsById(Request $request)
    {

      $userFunctions = UserFunction::where('user_id','=', $request->id)->get();
      return $userFunctions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserFunctionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFunctionRequest $request)
    {
        $user_funtions = UserFunction::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $user_funtions = UserFunction::findOrFail($request->id);
      return $user_funtions;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserFunctionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserFunctionRequest $request)
    {
      $user_funtions = UserFunction::findOrFail($request->id);
      $user_funtions->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
          $user_funtions = UserFunction::destroy($request->id);
    }
}
