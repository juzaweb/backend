<?php

namespace Tadcms\Backend\Macros;

class RouterMacros
{
    public function tadResource()
    {
        return function ($uri, $controller, $options = []) {
            $default = [
                'name' => '',
            ];
    
            $options = array_merge($default, $options);
            
            $uri_name = $options['name'] ? $options['name'] :
                str_replace('/', '.', $uri);
            
            $this->get($uri, $controller . '@index')->name('admin.' . $uri_name);
            
            $this->get($uri . '/create', $controller . '@form')->name('admin.' . $uri_name . '.create');
    
            $this->get($uri . '/edit/{id}', $controller . '@form')->name('admin.' . $uri_name . '.edit')->where('id', '[0-9]+');
            
            $this->get($uri . '/get-data', $controller . '@getDataTable')->name('admin.' . $uri_name . '.get-data');
            
            $this->post($uri . '/save', $controller . '@save')->name('admin.' . $uri_name . '.save');
            
            $this->post($uri . '/bulk-actions', $controller . '@bulkActions')->name('admin.' . $uri_name . '.bulk-actions');
        };
    }
}