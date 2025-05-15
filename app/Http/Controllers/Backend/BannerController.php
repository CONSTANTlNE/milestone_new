<?php

namespace App\Http\Controllers\Backend;

use App\Contracts\BannerInterface;
use App\DataTables\BannersDataTable;
use App\DataTables\BannersDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\Banner\BannerCreateRequest;
use App\Http\Requests\Banner\BannerUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Services\BannerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Banner;
use Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class BannerController extends Controller
{
    private BannerService $bannerService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
        $this->authorizeResource(Banner::class, 'banner');
    }
    /**
     * View all Banners.
     *
     * @param BannersDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(BannersDataTable $dataTable)
    {
        $this->authorize('viewAny', Banner::class);
        return $dataTable->render('backend.banners.index');
    }

    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',Banner::class);
        try {
            return $this->bannerService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status banner: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create view the specified resource.
     *
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create', Banner::class);
        return view('backend.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BannerCreateRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(BannerCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Banner::class);
        try {
            $this->bannerService->store($request);
            return redirect()->route('backend.banners.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating banner: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param Banner $banner
     * @return JsonResponse|View
     */
    public function show($lang, Banner $banner): JsonResponse|View
    {
        $this->authorize('view', $banner);
        try {
            return view('backend.banners.show', [
                'banner' => $this->bannerService->show($banner)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the banner: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param Banner $banner
     * @return JsonResponse|View
     */
    public function edit($lang, Banner $banner): JsonResponse|View
    {
        $this->authorize('update', $banner);
        try {
            return view('backend.banners.edit', [
                'banner' => $this->bannerService->edit($banner)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the banner: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param Banner $banner
     * @return JsonResponse|View
     */
    public function update($lang, BannerUpdateRequest $request, Banner $banner): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $banner);
        try {
            $this->bannerService->update($request, $banner);
            return redirect()->route('backend.banners.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating banner: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Banner.
     * @param $lang
     * @param Banner $banner
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, Banner $banner): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $banner);
        try {
            $this->bannerService->destroy($banner);
            return redirect()->route('backend.banners.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting banner: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Banner.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', Banner::class);
        try {
            $this->bannerService->massDestroy($request);
            return redirect()->route('backend.banners.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting banner: ' . $e->getMessage()
            ], 500);
        }
    }

    public function position()
    {
        $this->authorize('position', Banner::class);
        return view('backend.banners.position', [
            'banners' => $this->bannerService->getBannerPosition()
        ]);
    }
    public function reorder(Request $request)
    {
        return $this->bannerService->reorder($request);
    }

    // Archive

    /**
     * View all Banners in Trash.
     *
     * @param BannersDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(BannersDataTableTrash $dataTable)
    {
        $this->authorize('trash', Banner::class);
        return $dataTable->render('backend.banners.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Banner::class);
        try {
            $this->bannerService->restore($id);
            return redirect()->route('backend.banners.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring banner: ' . $e->getMessage()
            ], 500);
        }

    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Banner::class);
        try {
            $this->bannerService->remove($id);
            return redirect()->route('backend.banners.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing banner: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Banner::class);
        try {
            $this->bannerService->massRemove($request);
            return redirect()->route('backend.banners.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing banner: ' . $e->getMessage()
            ], 500);
        }
    }
}
