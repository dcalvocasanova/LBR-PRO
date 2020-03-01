<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $questions = Question::latest()->paginate(5);
      return $questions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  QuestionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
      $question = Question::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $question = Question::findOrFail($request->id);
      return $question;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  QuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request)
    {
      $question = Question::findOrFail($request->id);
      $question->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $question = Question::destroy($request->id);
    }
}
