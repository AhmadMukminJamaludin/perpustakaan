<?php
use Illuminate\Support\Facades\DB;

if (!function_exists('getMenuTree')) {
    function getMenuTree() {
        $menus = DB::table('menu')->orderBy('level')->get();
        
        return buildMenuTree($menus);
    }
}

if (!function_exists('buildMenuTree')) {
    function buildMenuTree($menus, $parentId = null) {
        $branch = [];
        foreach ($menus as $menu) {
            if ($menu->parent_id == $parentId) {
                $children = buildMenuTree($menus, $menu->id);
                if ($children) {
                    $menu->children = $children;
                }
                $branch[] = $menu;
            }
        }
        return $branch;
    }
}
