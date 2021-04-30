<?php

namespace Tadcms\Backend\Livewire\Media;

use Illuminate\Support\Collection;
use Livewire\Component;
use Tadcms\FileManager\Facades\FileManager;
use Tadcms\FileManager\Models\FolderMedia;
use Tadcms\FileManager\Models\Media;

class MediaList extends Component
{
    public $items = [];
    public $folderId;
    
    public function mount($folderId = null)
    {
        $this->folderId = $folderId;
    }
    
    public function loadItems()
    {
        $sQuery = collect(request()->query());
        $this->items = array_merge($this->getDirectories($sQuery), $this->getFiles($sQuery));
    }
    
    public function render()
    {
        return view('tadcms::livewire.media.media-list');
    }

    /**
     * Get files in folder
     * @param Collection $sQuery
     * @return array
     * */
    protected function getFiles($sQuery)
    {
        $result = [];
        $fileIcon = $this->getFileIcon();
        $query = Media::whereFolderId($this->folderId);

        if ($sQuery->get('type')) {
            $query->where('type', '=', $sQuery->get('type'));
        }

        $files = $query->get();
        foreach ($files as $row) {
            $fileUrl = FileManager::url($row->path);
            $thumb = FileManager::isImage($row) ? $fileUrl : null;
            $icon = isset($fileIcon[strtolower($row->extension)]) ?
                $fileIcon[strtolower($row->extension)] : 'fa-file-o';
        
            $result[] = (object) [
                'id' => $row->id,
                'name' => $row->name,
                'url' => $fileUrl,
                'size' => $row->size,
                'updated' => strtotime($row->updated_at),
                'path' => $row->path,
                'time' => (string) $row->created_at,
                'type' => $row->type,
                'icon' => $icon,
                'thumb' => $thumb,
                'is_file' => true
            ];
        }
        
        return $result;
    }

    /**
     * Get directories in folder
     * @param Collection $sQuery
     * @return array
     * */
    protected function getDirectories($sQuery)
    {
        $result = [];
        $query = FolderMedia::whereParentId($this->folderId);

        if ($sQuery->get('type')) {
            $query->where('type', '=', $sQuery->get('type'));
        }

        $directories = $query->get();
        foreach ($directories as $row) {
            $result[] = (object) [
                'id' => $row->id,
                'name' => $row->name,
                'url' => '',
                'size' => '',
                'updated' => strtotime($row->updated_at),
                'path' => $row->id,
                'time' => (string) $row->created_at,
                'type' => $row->type,
                'icon' => 'fa-folder-o',
                'thumb' => asset('tadcms/filemanager/images/folder.png'),
                'is_file' => false
            ];
        }
    
        return $result;
    }
    
    protected function getFileIcon()
    {
        return [
            'pdf'  => 'fa-file-pdf-o',
            'doc'  => 'fa-file-word-o',
            'docx' => 'fa-file-word-o',
            'xls'  => 'fa-file-excel-o',
            'xlsx' => 'fa-file-excel-o',
            'rar'  => 'fa-file-archive-o',
            'zip'  => 'fa-file-archive-o',
            'gif'  => 'fa-file-image-o',
            'jpg'  => 'fa-file-image-o',
            'jpeg' => 'fa-file-image-o',
            'png'  => 'fa-file-image-o',
            'ppt'  => 'fa-file-powerpoint-o',
            'pptx' => 'fa-file-powerpoint-o',
            'mp4'  => 'fa-file-video-o',
            'mp3'  => 'fa-file-video-o',
            'jfif' => 'fa-file-image-o',
            'txt'  => 'fa-file-text-o',
        ];
    }
}
