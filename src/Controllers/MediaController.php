<?php

namespace Tadcms\Backend\Controllers;

use Illuminate\Http\Request;
use Tadcms\System\Models\Media;
use Tadcms\Services\MediaService;
use Tadcms\Repositories\FolderMediaRepository;

class MediaController extends BackendController
{
    /**
     * @var MediaService $mediaService
     * */
    protected $mediaService;
    
    protected $folderRepository;
    
    public function __construct(
        Request $request,
        MediaService $mediaService,
        FolderMediaRepository $folderRepository
    )
    {
        parent::__construct($request);
    
        $this->mediaService = $mediaService;
    
        $this->folderRepository = $folderRepository;
    }
    
    public function index() {
        return view('tadcms::backend.media.index', [
            'title' => trans('tadcms::app.media')
        ]);
    }
    
    public function getDataTable() {
        $page_size = $this->request->get('page_size', 10);
        $folder_id = $this->request->get('folder_id');
    
        //$files = $this->mediaService->getFiles($folder_id, null, $page_size);
        $directories = $this->folderRepository->getDirectories($folder_id, null);
        
        $files = Media::where('folder_id', '=', $folder_id)
            ->paginate($page_size);
        
        $data = array_merge($directories, $files->items());
        
        return $this->response([
            'items' => $data,
            'load_more' => $files->nextPageUrl() ? true : false,
        ], true);
    }
}
