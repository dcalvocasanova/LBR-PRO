<?php

namespace App\Http\Controllers;
use App\Catalog;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\CatalogRequest;

class CatalogController extends Controller
{
  /**
   * Display a listing of the catalog.
   *
   * @return \Illuminate\Http\Response
   */
  public function getListCatalog(Request $request)
  {
    $catalogs = Catalog::where('type',$request->id)->get();
    return $catalogs;
  }

  /**
 * Store a newly created an item  in storage.
 *
 * @param  CatalogRequest  $request
 * @return \Illuminate\Http\Response
 */
  public function storeItem(CatalogRequest $request)
  {
    $catalog = Catalog::create($request->all());
  }

  /**
 *  Update the item in storage.
 *
 * @param  CatalogRequest  $request
 * @return \Illuminate\Http\Response
 */
  public function updateItem(CatalogRequest $request)
  {
    $catalog = Catalog::findOrFail($request->id);
    $catalog->update($request->all());
  }

  /**
   * Remove the specified item from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function deleteItem(Request $request)
  {
    $catalog = Catalog::destroy($request->id);
  }

  /**
   * Get all user types catalogs.
   *
   * @return \Illuminate\Http\Response
   */
  public function getRoles(Request $request)
  {
    $roles = Role::all();
    return $roles;
  }

  /**
 * Store a new role catalog  in storage.
 *
 * @param  CatalogRequest  $request
 * @return \Illuminate\Http\Response
 */
  public function storeRole(CatalogRequest $request)
  {
     Role::create(['name' => $request->name]);
  }
  /**
 *  Update the item in storage.
 *
 * @param  CatalogRequest  $request
 * @return \Illuminate\Http\Response
 */
  public function updateRole(CatalogRequest $request)
  {
    $rol = Role::findOrFail($request->id);
    $rol->update(['name' => $request->name]);
  }
  /**
   * Remove the specified role from storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function deleteRole(Request $request)
  {
    $rol = Role::findOrFail($request->id);
    $rol->revokePermissionTo(Permission::all());
    $rol->delete();
  }
  /**
   * Get the all permissions from a role .
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function getAllPermisssionsFromRole(Request $request)
  {
    $permissions = Role::findOrFail($request->id)->permissions->pluck('name');
    return $permissions;
  }
  /**
   * Get the all roles can be realted to a web system user.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function getRolesToSimpleUser(Request $request)
  {
    $listOfRoles = array();
    $roles = Role::all();

    foreach ($roles as $role ) {
      if(!($role->hasPermissionTo('CRUD_users')
       || $role->hasPermissionTo('CR_users')
       || $role->hasPermissionTo('R_reports')
       || $role->hasPermissionTo('CRUD_catalogs')
       || $role->hasPermissionTo('CR_projects')
       || $role->hasPermissionTo('CRUD_projects') )){
         array_push($listOfRoles,$role->name);
      }
    }
    return $listOfRoles;
  }
  /**
   * Get the all permissions from a role .
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function updatePermisssionsFromRole(Request $request)
  {
    $rol = Role::findOrFail($request->id);
    $rol->revokePermissionTo(Permission::all());
    $rol->givePermissionTo($request->roles);
  }
}
