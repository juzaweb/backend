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
use Tadcms\Backend\Contracts\ResourceControllerInterface;
use Tadcms\Backend\Controllers\BackendController;

abstract class ResourceControllerAbstract extends BackendController implements ResourceControllerInterface
{
    /**
     * @return \Tadcms\Repository\Eloquent\BaseRepository
     * */
    abstract protected function mainRepository();

    abstract protected function validateRequest(Request $request);

    abstract public function index();

    abstract public function create();

    abstract public function edit($id);

    public function store(Request $request)
    {
        $this->validateRequest($request);

        DB::beginTransaction();

        try {
            $this->mainRepository()->create($request->all());
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
        $this->validateRequest($request);

        DB::beginTransaction();

        try {
            $this->mainRepository()->update($request->all(), $id);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $this->success([
            'message' => trans('tadcms::app.create-successfully')
        ]);
    }

    public function getDataTable(Request $request)
    {
        //$search = $request->get('search');
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $query = $this->mainRepository();

        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();

        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
}
