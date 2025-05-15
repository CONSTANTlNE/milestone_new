<?php

namespace App\Http\Controllers\Backend;

use App\Contracts\MediaInterface;
use App\DataTables\MediasDataTable;
use App\DataTables\MediasDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\Media\MediaCreateRequest;
use App\Http\Requests\Media\MediaUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Services\MediaService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Media;
use Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class MediaController extends Controller
{
    private MediaService $mediaService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
        $this->authorizeResource(Media::class, 'media');
    }
    /**
     * View all Medias.
     *
     * @param MediasDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(MediasDataTable $dataTable)
    {
        $this->authorize('viewAny', Media::class);
        return $dataTable->render('backend.medias.index');
    }

    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',Media::class);
        try {
            return $this->mediaService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status media: ' . $e->getMessage()
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
        $this->authorize('create', Media::class);
        return view('backend.medias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MediaCreateRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(MediaCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Media::class);
        try {
            $this->mediaService->store($request);
            return redirect()->route('backend.medias.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating media: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param Media $media
     * @return JsonResponse|View
     */
    public function show($lang, Media $media): JsonResponse|View
    {
        $this->authorize('view', $media);
        try {
            return view('backend.medias.show', [
                'media' => $this->mediaService->show($media)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the media: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param Media $media
     * @return JsonResponse|View
     */
    public function edit($lang, Media $media): JsonResponse|View
    {
        $this->authorize('update', $media);
        try {
            return view('backend.medias.edit', [
                'media' => $this->mediaService->edit($media)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the media: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param Media $media
     * @return JsonResponse|View
     */
    public function update($lang, MediaUpdateRequest $request, Media $media): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $media);
        try {
            $this->mediaService->update($request, $media);
            return redirect()->route('backend.medias.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating media: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Media.
     * @param $lang
     * @param Media $media
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, Media $media): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $media);
        try {
            $this->mediaService->destroy($media);
            return redirect()->route('backend.medias.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting media: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Media.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', Media::class);
        try {
            $this->mediaService->massDestroy($request);
            return redirect()->route('backend.medias.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting media: ' . $e->getMessage()
            ], 500);
        }
    }

    // Archive

    /**
     * View all Medias in Trash.
     *
     * @param MediasDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(MediasDataTableTrash $dataTable)
    {
        $this->authorize('trash', Media::class);
        return $dataTable->render('backend.medias.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Media::class);
        try {
            $this->mediaService->restore($id);
            return redirect()->route('backend.medias.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring media: ' . $e->getMessage()
            ], 500);
        }

    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Media::class);
        try {
            $this->mediaService->remove($id);
            return redirect()->route('backend.medias.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing media: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Media::class);
        try {
            $this->mediaService->massRemove($request);
            return redirect()->route('backend.medias.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing media: ' . $e->getMessage()
            ], 500);
        }
    }
}
