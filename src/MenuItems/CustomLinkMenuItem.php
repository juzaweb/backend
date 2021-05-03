<?php

namespace Tadcms\Backend\MenuItems;

use Tadcms\Backend\Abstracts\MenuItemAbstract;

class CustomLinkMenuItem extends MenuItemAbstract
{
    public static function formAdd()
    {
        return view('tadcms::menu_items.custom_link.form_add');
    }

    public static function formEdit($data)
    {
        return view('tadcms::menu_items.custom_link.form_edit', [
            'data' => $data
        ]);
    }

    public static function validateData()
    {
        return [
            'text' => 'required',
            'url' => 'string'
        ];
    }

    public static function addData($request)
    {
        return [
            'text' => $request->input('text'),
            'url' => $request->input('url')
        ];
    }

    public static function getLink($data)
    {
        return $data->get('url');
    }
}
