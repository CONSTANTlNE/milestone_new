<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\Product\ProductCategoryRepository;
use App\Interfaces\Product\ProductCategoryRepositoryInterface;
use App\Http\Requests\Product\CreateProductCategory;
use App\Http\Requests\Product\UpdateProductCategory;
use App\Models\ProductCategory;
use Gate;

class ProductCategoryController extends Controller
{

    private $productCategoryRepository;

    public function __construct(ProductCategoryRepositoryInterface $productCategoryRepository) 
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    public function index(Request $request){
        Gate::authorize('backend.productCategory.index');
        return $this->productCategoryRepository->index($request);
    }

    public function status(Request $request)
    {
        Gate::authorize('backend.productCategory.status');
        return $this->productCategoryRepository->status($request);
    }

    public function create()
    {
        Gate::authorize('backend.productCategory.create');
        return view('backend.productCategory.create', [
          'productCategories' => $this->productCategoryRepository->create()
        ]);
    }

    public function store(CreateProductCategory $request){
        Gate::authorize('backend.productCategory.store');
        $this->productCategoryRepository->store($request);
        return redirect()->route('backend.productCategory.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function show($lang, $id)
    {
        Gate::authorize('backend.productCategory.show');
        return view('backend.productCategory.show', [
          'productCategory' => $this->productCategoryRepository->show($id)
        ]);
    }

    public function edit($lang, $id)
    {
        Gate::authorize('backend.productCategory.edit');
        return view('backend.productCategory.edit', [
          'productCategory' => $this->productCategoryRepository->edit($id),
          'seo' => $this->productCategoryRepository->getSeoFirst($id),
          'allProductCategories' => $this->productCategoryRepository->getlist()
        ]);
    }

    public function update(UpdateProductCategory $request){
        Gate::authorize('backend.productCategory.update');
        $this->productCategoryRepository->update($request);
        return redirect()->route('backend.productCategory.index', app()->getLocale())
                      ->with('success','წარმატებით დაემატა!');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.productCategory.destroy');
        $this->productCategoryRepository->destroy($id);
        return redirect()->route('backend.productCategory.index', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Gate::authorize('backend.productCategory.destroy');
        return $this->productCategoryRepository->massDestroy($request);
    }

    public function reorder(Request $request)
    {
        return $this->productCategoryRepository->reorder($request);
    }

    public function trash(Request $request)
    {
        Gate::authorize('backend.productCategory.trash');
        return $this->productCategoryRepository->trash($request);
    }

    public function restore(Request $request) 
    {
        Gate::authorize('backend.productCategory.restore');
        $this->productCategoryRepository->restore($request);
        return redirect()->route('backend.productCategory.trash', app()->getLocale())
                      ->with('success','წარმატებით აღდგა ჩანაწერი!');
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.productCategory.remove');
        $this->productCategoryRepository->remove($request);
        return redirect()->route('backend.productCategory.trash', app()->getLocale())
                      ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        Gate::authorize('backend.productCategory.remove');
        $this->productCategoryRepository->massRemove($request);
    }
}

