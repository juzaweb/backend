<?php
/**
 * @package    tadcms\tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/1/2021
 * Time: 2:15 PM
 */

namespace Tadcms\Backend\Abstracts;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tadcms\Backend\Controllers\BackendController;

abstract class ResourceControllerAbstract extends BackendController
{
    /**
     * @var \Tadcms\Repository\Eloquent\BaseRepository
     * */
    protected $repository;
    /**
     * @return \Tadcms\Repository\Eloquent\BaseRepository
     * */
    abstract protected function repository();

    abstract public function index();

    abstract public function create();

    abstract public function edit($id);

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->repository->create($request->all());
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $this->success([
            'message' => trans('tadcms::app.create-successfully')
        ]);
    }

    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $this->repository->update($request->all(), $id);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $this->success([
            'message' => trans('tadcms::app.create-successfully')
        ]);
    }

    abstract public function getDataTable(Request $request);
}