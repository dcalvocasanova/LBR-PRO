<?php

namespace App\Http\Controllers;

use App\Criteria;
use Illuminate\Http\Request;
use App\Http\Requests\CriteriaRequest;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $criterias = criteria::latest()->paginate(5);
      return $criterias;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
      $criterias = criteria::latest()->get();
      return $criterias;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  criteriaRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(criteriaRequest $request)
    {
      $question = criteria::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
      $question = criteria::findOrFail($request->id);
      return $question;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  criteriaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(criteriaRequest $request)
    {
      $question = criteria::findOrFail($request->id);
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
        $question = criteria::destroy($request->id);
    }
}
