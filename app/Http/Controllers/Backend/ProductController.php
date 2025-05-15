<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Product\ProductRepository;
use App\Interfaces\Product\ProductRepositoryInterface;
use App\Http\Requests\Product\CreateProduct;
use App\Http\Requests\Product\UpdateProduct;
use App\Models\Product;
use Gate;

class ProductController extends Controller
{

    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository) 
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.products.index');
        return $this->productRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.products.status');
        return $this->productRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.products.create');
        return view('backend.products.create', [
          'productCategories' => $this->productRepository->create()
        ]);
    }

    public function store(CreateProduct $request){
        Gate::authorize('backend.products.store');
        $this->productRepository->store($request);
        return redirect()->route('backend.products.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.products.show');
        return view('backend.products.show', [
          'product' => $this->productRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.products.edit');
        return view('backend.products.edit', [
          'product' => $this->productRepository->edit($id),
          'seo' => $this->productRepository->getSeoFirst($id),
          'allProductCategories' => $this->productRepository->getProductCategory()
        ]);
    }

    public function update(UpdateProduct $request){
        Gate::authorize('backend.products.update');
        $this->productRepository->update($request);
        return redirect()->route('backend.products.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.products.destroy');
        $this->productRepository->destroy($id);
        return redirect()->route('backend.products.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.products.destroy');
        return $this->productRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->productRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.products.trash');
        return $this->productRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.products.restore');
        $this->productRepository->restore($request);
        return redirect()->route('backend.products.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.products.remove');
        $this->productRepository->remove($request);
        return redirect()->route('backend.products.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.products.remove');
        $this->productRepository->massRemove($request);
    }
}

