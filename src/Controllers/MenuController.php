<?php

namespace Tadcms\Backend\Controllers;

class MenuController extends BackendController
{
    public function menuLeftItems() {
        $items = apply_filters('admin_menu', []);
        $menu = [];
        
        foreach ($items as $item) {
            $child = [];
            
            if (isset($item['children'])) {
                foreach ($item['children'] as $children) {
                    $child[] = $this->createUrlItemMenu($children);
                }
    
                unset($item['children']);
            }
            
            if ($child) {
                $item['children'] = $child;
            }
            
            $menu[] = $this->createUrlItemMenu($item);
        }
        
        return $this->response([
            'items' => $menu,
        ], true);
    }
    
    public function menuTopItems() {
        $items = apply_filters('admin_menu-top', []);
        $menu = [];
    
        foreach ($items as $item) {
            $child = [];
        
            if (isset($item['children'])) {
                foreach ($item['children'] as $children) {
                    $child[] = $this->createUrlItemMenu($children);
                }
            
                unset($item['children']);
            }
        
            if ($child) {
                $item['children'] = $child;
            }
        
            $menu[] = $this->createUrlItemMenu($item);
        }
        
        return $this->response([
            'items' => $menu,
        ], true);
    }
    
    protected function createUrlItemMenu($item) {
        $item['url'] = '/' . str_replace('.', '/', $item['url']);
        return $item;
    }
}