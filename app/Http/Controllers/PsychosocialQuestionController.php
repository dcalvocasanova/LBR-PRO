<?php

namespace App\Http\Controllers;

use App\PsychosocialQuestion;
use Illuminate\Http\Request;

class PsychosocialQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $psychosocialQuestions = PsychosocialQuestion::paginate(10);
      return $psychosocialQuestions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $psychosocialQuestion = PsychosocialQuestion::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $psychosocialQuestion = PsychosocialQuestion::findOrFail($request->id);
      return $psychosocialQuestion;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $psychosocialQuestion = PsychosocialQuestion::findOrFail($request->id);
      $psychosocialQuestion->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $psychosocialQuestion = PsychosocialQuestion::destroy($request->id);
    }

    /**
     * Get the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(){
        if ($search = \Request::get('q')) {
            $psychosocialQuestions = PsychosocialQuestion::where(function($query) use ($search){
                $query->where('question','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $psychosocialQuestions = Project::PsychosocialQuestion()->paginate(10);
        }
        return $psychosocialQuestions;
    }  
}
