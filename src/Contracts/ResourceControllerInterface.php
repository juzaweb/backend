<?php
/**
 * @package    tadcms\tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/3/2021
 * Time: 11:39 AM
 */

namespace Tadcms\Backend\Contracts;

use Illuminate\Http\Request;

interface ResourceControllerInterface
{
    public function index();

    public function create();

    public function edit(int $id);

    public function store(Request $request);

    public function update($id, Request $request);

    public function getDataTable(Request $request);

    public function bulkActions(Request $request);
}
