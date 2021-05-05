<?php

namespace Tadcms\Backend\Abstracts;

abstract class MenuItemAbstract
{
    /**
     * Render component view form items
     *
     * @return \Illuminate\View\View
     * */
    abstract public static function formAdd();

    /**
     * Render component view form items
     *
     * @param mixed $data
     * @return \Illuminate\View\View
     * */
    abstract public static function formEdit($data);

    public static function validateData()
    {
        return [];
    }

    /**
     * @param \Illuminate\Http\Request $request
     * */
    abstract public static function addData($request);

    /**
     * Render component view form items
     *
     * @param \Illuminate\Support\Collection $data
     * @return string
     * */
    abstract public static function getLink($data);
}
