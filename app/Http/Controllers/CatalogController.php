<?php

namespace App\Http\Controllers;
use App\Catalog;
use App\RiskParameter;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\CatalogRequest;
use app\Traits\CatalogSystemTraits;


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
  * Get PHVA catalog
  */
  public function getPHVACatalog()
  {
    $catalogs = $this->getPHVACatalogHelper();
    return $catalogs;
  }

  /**
  * Get Risks catalog
  */
  public function getRiskCatalog()
  {
      $catalogs = $this->getRiskCatalogHelper();
    return $catalogs;
  }

  /**
  * Get Skills catalog
  */
  public function getSkillTaskCatalog()
  {
      $catalogs = $this->getSkillsCatalogHelper();
    return $catalogs;
  }

  /**
  * Get Skills catalog
  */
  public function getWorkTypeCatalog()
  {
      $catalogs = $this->getWorkTypeCatalogHelper();
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
  /**
   * Get the all permissions from a role .
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function saveRiskEvents(Request $request)
  {
    $catalog = RiskParameter::create($request->all());
  }

  function getPHVACatalogHelper()
  {
    $catalogList = Array();
    $itemList = Array();
    $ps = Catalog::select('id','name')->where('type','P')->get();
    $hs = Catalog::select('id','name')->where('type','H')->get();
    $vs = Catalog::select('id','name')->where('type','V')->get();
    $as = Catalog::select('id','name')->where('type','A')->get();
    foreach ($ps as $p) {
      array_push($itemList,array('id'=> $p->id,'label'=>$p->name));
    }
    array_push($catalogList, array('id'=>'P', 'label'=>'Planear','children'=>$itemList));
    $itemList=[];
    foreach ($hs as $h) {
      array_push($itemList,array('id'=> $h->id,'label'=>$h->name));
    }
    array_push($catalogList, array('id'=>'H', 'label'=>'Hacer','children'=>$itemList));
    $itemList=[];
    foreach ($vs as $v) {
      array_push($itemList,array('id'=> $v->id,'label'=>$v->name));
    }
    array_push($catalogList, array('id'=>'V', 'label'=>'Verificar','children'=>$itemList));
    $itemList=[];
    foreach ($as as $a) {
      array_push($itemList,array('id'=> $a->id,'label'=>$a->name));
    }
    array_push($catalogList, array('id'=>'A', 'label'=>'Actuar','children'=>$itemList));
    $itemList=[];
    return  $catalogList;
  }
  function getSkillsCatalogHelper()
  {
    $catalogList = Array();
    $itemList = Array();
    $skills = Catalog::select('id','name')->where('type', 'SKILL-T')->get();
    foreach ($skills as $s) {
      $categories = Catalog::select('id','name')->where('type', $s->id."-T")->get();
      foreach ($categories as $c) {
        array_push($itemList,array('id'=> $c->id,'label'=>$c->name));
      }
      array_push($catalogList, array('id'=>$s->id, 'label'=>$s->name,'children'=>$itemList));
      $itemList=[];
    }
    return  $catalogList;
  }
  function getWorkTypeCatalogHelper()
  {
    $catalogList = Array();
    $itemList = Array();
    $workTypes = Catalog::select('id','name')->where('type', 'WORKTYPE')->get();
    foreach ($workTypes as $wt) {
      $categories = Catalog::select('id','name')->where('type', $wt->id."-T")->get();
      foreach ($categories as $c) {
        array_push($itemList,array('id'=> $c->id,'label'=>$c->name));
      }
      array_push($catalogList, array('id'=>$wt->id, 'label'=>$wt->name,'children'=>$itemList));
      $itemList=[];
    }
    return  $catalogList;
  }
  function getRiskCatalogHelper()
  {
    $catalogList = Array();
    $itemList = Array();
    $subItemList = Array();
    $risks = Catalog::select('id','name')->where('type', 'RISK-T')->get();
    foreach ($risks as $r) {
      $categories = Catalog::select('id','name')->where('type',$r->id."-T" )->get();
      foreach ($categories as $c) {
        $SubCategories = Catalog::select('id','name')->where('type', $c->id."-T")->get();
        foreach ($SubCategories as $sc) {
          array_push($subItemList,array('id'=> $sc->id,'label'=>$sc->name));
        }
        array_push($itemList,array('id'=> $c->id,'label'=>$c->name,'children'=>$subItemList));
        $subItemList=[];
      }
      array_push($catalogList, array('id'=>$r->id, 'label'=>$r->name,'children'=>$itemList));
      $itemList=[];
    }
    return  $catalogList;
  }
}
