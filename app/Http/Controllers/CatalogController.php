<?php

namespace App\Http\Controllers;
use App\Catalog;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
  /**
   * Display a listing of the gender catalog.
   *
   * @return \Illuminate\Http\Response
   */
  public function getListCatalog(Request $request)
  {
    $catalogs = Catalog::where('type',$request->id)->get();
    return $catalogs;
  }

  /**
 * Store a newly created a Gender item  in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
  public function storeItem(Request $request)
  {
    $this->validate($request,[
        'nombre' => 'required'
    ]);

    $catalog = new Catalog();
    $catalog->name = $request->nombre;
    $catalog->type = $request->tipo;
    $catalog->save();

  }

  /**
 *  Update the gender item in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
  public function updateItem(Request $request)
  {
    $this->validate($request,[
        'nombre' => 'required'
    ]);

    $catalog = Catalog::findOrFail($request->id);
    $catalog->name = $request->nombre;
    $catalog->save();

  }

  /**
   * Remove the specified gender item from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function deleteItem(Request $request)
  {
    $catalog = Catalog::destroy($request->id);
  }
}
