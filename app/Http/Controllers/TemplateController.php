<?php

namespace App\Http\Controllers;

use App\Template;
use App\Http\Resquests\TemplateRequest;
use Illuminate\Http\Request;

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
}
