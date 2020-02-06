<?php

namespace App\Http\Controllers;

use App\Template;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\TemplateRequest;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $templates = Template::latest()->paginate(5);
      return $templates;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TemplateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TemplateRequest $request)
    {
      $template = Template::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show (Request $request)
    {
      $template = Template::findOrFail($request->id);
      return $template;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TemplateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(TemplateRequest $request)
    {
      $template = Template::findOrFail($request->id);
      $template->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
      $template = Template::destroy($request->id);
    }

    /**
     * Get all variables according to a type
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getTeplatesByType(Request $request)
    {
      $template = Template::where('type',$request->type)->latest()->paginate(5);
      return $template;
    }
}
