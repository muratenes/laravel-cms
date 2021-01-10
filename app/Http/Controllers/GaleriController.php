<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Repositories\Interfaces\FotoGalleryInterface;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    private FotoGalleryInterface $_galleryService;

    public function __construct(FotoGalleryInterface $galleryService)
    {
        $this->_galleryService = $galleryService;
    }

    public function list()
    {
        if (!config('admin.use_album_gallery')) {
            return redirect(route('gallery.edit', 0));
        }
        $list = $this->_galleryService->allWithPagination();
        return view('gallery.listGallery', compact('list'));
    }

    public function detail(Gallery $gallery)
    {
        return view('gallery.galleryDetail', compact('gallery'));
    }
}
