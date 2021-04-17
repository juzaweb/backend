<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Theanh\FileManager\Repositories\FolderMediaRepository;
use Theanh\FileManager\Exceptions\UploadMissingFileException;
use Theanh\FileManager\Handler\HandlerFactory;
use Theanh\FileManager\Receiver\FileReceiver;

class MediaController extends BackendController
{
    protected $folderRepository;
    
    public function __construct(FolderMediaRepository $folderRepository)
    {
        $this->folderRepository = $folderRepository;
    }
    
    public function index($fileType = 'image', $folderId = null)
    {
        return view('tadcms::media.index', [
            'fileTypes' => $this->getFileTypes(),
            'fileType' => $fileType,
            'folderId' => $folderId,
            'title' => trans('tadcms::app.media')
        ]);
    }
    
    public function upload(Request $request)
    {
        $receiver = new FileReceiver(
            'upload',
            $request,
            HandlerFactory::classFromRequest($request)
        );
    
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
    
        $save = $receiver->receive();
        if ($save->isFinished()) {
            try {
                DB::beginTransaction();
                $new_file = $this->saveFile($save->getFile());
                DB::commit();
            }
            catch (\Exception $exception) {
                DB::rollBack();
                unlink($save->getFile()->getRealPath());
                throw $exception;
            }
        
            if ($new_file) {
            
                // event
            
                return response()->json([
                    'status' => true,
                    'data' => [
                        'message' => 'Upload success.'
                    ]
                ]);
            }
        
            return 'Can\'t save your file.';
        }
    
        $handler = $save->handler();
    
        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
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
            throw $exception;
        }
    
        // event
    
        return $this->success(trans('tadcms::app.add-folder-successfully'));
    }
    
    protected function getFileTypes()
    {
        return config('file-manager.file_types');
    }
}
