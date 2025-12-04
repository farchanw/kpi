<?php

namespace App\Helpers;

use Idev\EasyAdmin\app\Helpers\Constant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Sidebar
{

  public function generate()
  {    
    $menus = $this->menus();
    $constant = new Constant();
    $permission = $constant->permissions();

    $arrMenu = [];
    foreach ($menus as $key => $menu) {
      $visibilityMenu = in_array($menu['key'] . ".index", $permission['list_access']);
      if (isset($menu['override_visibility'])) {
        $visibilityMenu = $menu['override_visibility'];
      }
      $menu['visibility'] = $visibilityMenu;
      $menu['url'] = (Route::has($menu['key'].".index")) ? route($menu['key'].".index") : "#";
      $menu['base_key'] = $menu['key'];
      $menu['key'] = $menu['key'].".index";

      $arrMenu[] = $menu;
    }
    return $arrMenu;
  }


  public function menus(){
    $role = "admin";
    if(config('idev.enable_role',true)){
      $role = Auth::user()->role->name;
    }
    return
      [
        [
          'name' => 'Dashboard',
          'icon' => 'ti ti-dashboard',
          'key' => 'dashboard',
          'base_key' => 'dashboard',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Role',
          'icon' => 'ti ti-key',
          'key' => 'role',
          'base_key' => 'role',
          'visibility' => in_array($role, ['admin']),
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'User',
          'icon' => 'ti ti-users',
          'key' => 'user',
          'base_key' => 'user',
          'visibility' => in_array($role, ['admin']),
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Division',
          'icon' => 'ti ti-menu',
          'key' => 'division',
          'base_key' => 'division',
          'visibility' => true,
          'ajax_load' => false,
          'name' => 'Division',
          'icon' => 'ti ti-menu',
          'key' => 'division',
          'base_key' => 'division',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Grading',
          'icon' => 'ti ti-menu',
          'key' => 'grading',
          'base_key' => 'grading',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Aspect',
          'icon' => 'ti ti-menu',
          'key' => 'aspect',
          'base_key' => 'aspect',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Employee',
          'icon' => 'ti ti-menu',
          'key' => 'employee',
          'base_key' => 'employee',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Evaluator',
          'icon' => 'ti ti-menu',
          'key' => 'evaluator',
          'base_key' => 'evaluator',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Indicator',
          'icon' => 'ti ti-menu',
          'key' => 'indicator',
          'base_key' => 'indicator',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Kpi Template',
          'icon' => 'ti ti-menu',
          'key' => 'kpi-template',
          'base_key' => 'kpi-template',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
        [
          'name' => 'Kpi Entry',
          'icon' => 'ti ti-menu',
          'key' => 'kpi-entry',
          'base_key' => 'kpi-entry',
          'visibility' => true,
          'ajax_load' => false,
          'childrens' => []
        ],
      ];
  }


  public function defaultAllAccess($exclude = []) {
    return ['list', 'create','show', 'edit', 'delete','import-excel-default', 'export-excel-default','export-pdf-default'];
  }


  public function accessCustomize($menuKey)
  {
    $arrMenu = [
      'dashboard' => ['list'],
    ];

    return $arrMenu[$menuKey] ?? $this->defaultAllAccess();
  }

}
