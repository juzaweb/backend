<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Theanh\FileManager\Models\FolderMedia;
use Theanh\FileManager\Repositories\FolderMediaRepository;

class MediaController extends BackendController
{
    protected $folderRepository;
    
    public function __construct(FolderMediaRepository $folderRepository)
    {
        $this->folderRepository = $folderRepository;
    }
    
    public function index($folderId = null)
    {
        $title = trans('tadcms::app.media');
        if ($folderId) {
            $this->addBreadcrumb([
                'title' => $title,
                'url' => route('admin.media'),
            ]);

            $folder = FolderMedia::find($folderId);
            $folder->load('parent');
            $this->addBreadcrumbFolder($folder);
            $title = $folder->name;
        }

        return view('tadcms::media.index', [
            'fileTypes' => $this->getFileTypes(),
            'folderId' => $folderId,
            'title' => $title
        ]);
    }
    
    public function addFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'parent_id' => 'nullable|exists:lfm_folder_media,id',
        ], [], [
            'name' => trans('filemanager::file-manager.folder-name'),
            'parent_id' => trans('filemanager::file-manager.parent')
        ]);
    
        $name = $request->post('name');
        $parentId = $request->post('parent_id');
    
        if ($this->folderRepository->exists([
            'name' => $name,
            'parent_id' => $parentId
        ])) {
            return $this->error(
                trans('filemanager::file-manager.errors.folder-exists')
            );
        }
    
        try {
            DB::beginTransaction();
            $this->folderRepository->create(
                $request->all()
            );
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error($exception->getMessage());
        }
    
        // event
    
        return $this->success(trans('tadcms::app.add-folder-successfully'));
    }
    
    protected function getFileTypes()
    {
        return config('file-manager.file_types');
    }

    protected function addBreadcrumbFolder($folder)
    {
        $parent = $folder->parent;
        if ($parent) {
            $this->addBreadcrumb([
                'title' => $parent->name,
                'url' => route('admin.media.folder', $parent->id),
            ]);

            $parent->load('parent');
            if ($parent->parent) {
                $this->addBreadcrumbFolder($parent);
            }
        }
    }
}
