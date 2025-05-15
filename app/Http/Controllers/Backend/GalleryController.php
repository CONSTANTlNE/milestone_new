<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Gallery\GalleryRepository;
use App\Interfaces\Gallery\GalleryRepositoryInterface;
use App\Http\Requests\Gallery\CreateGallery;
use App\Http\Requests\Gallery\UpdateGallery;
use App\Models\Gallery;
use Gate;

class GalleryController extends Controller
{

    private $galleryRepository;

    public function __construct(GalleryRepositoryInterface $galleryRepository) 
    {
        $this->galleryRepository = $galleryRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.gallery.index');
        return $this->galleryRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.gallery.status');
        return $this->galleryRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.gallery.create');
        return view('backend.gallery.create');
    }

    public function store(CreateGallery $request){
        Gate::authorize('backend.gallery.store');
        $this->galleryRepository->store($request);
        return redirect()->route('backend.gallery.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.gallery.show');
        return view('backend.gallery.show', [
          'gallery' => $this->galleryRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.gallery.edit');
        return view('backend.gallery.edit', [
          'gallery' => $this->galleryRepository->edit($id),
          'seo' => $this->galleryRepository->getSeoFirst($id),
        ]);
    }

    public function update(UpdateGallery $request){
        Gate::authorize('backend.gallery.update');
        $this->galleryRepository->update($request);
        return redirect()->route('backend.gallery.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.gallery.destroy');
        $this->galleryRepository->destroy($id);
        return redirect()->route('backend.gallery.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.gallery.destroy');
        return $this->galleryRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->galleryRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.gallery.trash');
        return $this->galleryRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.gallery.restore');
        $this->galleryRepository->restore($request);
        return redirect()->route('backend.gallery.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.gallery.remove');
        $this->galleryRepository->remove($request);
        return redirect()->route('backend.gallery.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.gallery.remove');
        $this->galleryRepository->massRemove($request);
    }
}

