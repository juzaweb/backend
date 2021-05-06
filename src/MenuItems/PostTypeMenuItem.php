<?php
/**
 * @package    tadcms\tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/6/2021
 * Time: 8:13 PM
 */

namespace Tadcms\Backend\MenuItems;

use Tadcms\Backend\Abstracts\MenuItemAbstract;
use Tadcms\System\Models\Post;

class PostTypeMenuItem extends MenuItemAbstract
{
    public static function formAdd()
    {
        return view('tadcms::menu_items.taxonomy.form_add');
    }

    public static function formEdit($data)
    {
        return view('tadcms::menu_items.taxonomy.form_edit');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     * */
    public static function addData($request)
    {
        $ids = $request->input('ids');
        $posts = Post::with('translations')
            ->whereIn('id', $ids)
            ->get(['id']);

        $result = [];
        foreach ($posts as $post) {
            $result[] = [
                'text' => $post->title,
                'id' => $post->id,
                'model' => Post::class,
            ];
        }

        return $result;
    }

    public static function getLink($data)
    {
        $taxonomy = Post::find($data->get('id'));
        return '/text/' . $taxonomy->slug;
    }
}
