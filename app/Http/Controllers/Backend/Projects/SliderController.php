<?php

namespace App\Http\Controllers\Backend\Projects;

use App\Http\Requests\Slider\SliderChangeStatusRequest;
use App\Http\Requests\Slider\SliderCreateRequest;
use App\Http\Requests\Slider\SliderDestroyRequest;
use App\Http\Requests\Slider\SliderIndexRequest;
use App\Http\Requests\Slider\SliderMassDestroyRequest;
use App\Http\Requests\Slider\SliderMassRemoveRequest;
use App\Http\Requests\Slider\SliderRemoveRequest;
use App\Http\Requests\Slider\SliderRestoreRequest;
use App\Http\Requests\Slider\SliderTrashRequest;
use App\Http\Requests\Slider\SliderUpdateRequest;
use App\Services\SliderService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    private SliderService $sliderService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }
    /**
     * Display a listing of the sliders.
     * @throws AuthorizationException
     */
    public function index(SliderIndexRequest $request): View
    {
        $this->authorize('viewAny', Slider::class);

        return view('backend.sliders.index', [
            'sliders' => $this->sliderService->index($request)
        ]);
    }

    /**
     * Change Status.
     *
     * @param SliderChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(SliderChangeStatusRequest $request): JsonResponse
    {
        try {
            return $this->sliderService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status Slider: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create view the specified resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Slider::class);
        return view('backend.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SliderCreateRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function store(SliderCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Slider::class);
        try {
            $this->sliderService->store($request);
            return redirect()->route('backend.sliders.index')
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating Slider: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Slider $slider
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function show(Slider $slider): JsonResponse|View
    {
        $this->authorize('view', $slider);

        try {
            return view('backend.sliders.show', [
                'slider' => $this->sliderService->show($slider)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the Slider: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param Slider $slider
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function edit(Slider $slider): JsonResponse|View
    {
        $this->authorize('update', $slider);

        try {
            return view('backend.sliders.edit', [
                'slider' => $this->sliderService->edit($slider)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the Slider: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param SliderUpdateRequest $request
     * @param Slider $slider
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(SliderUpdateRequest $request, Slider $slider): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $slider);

        try {
            $this->sliderService->update($request, $slider);
            return redirect()->route('backend.sliders.index')
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating Slider: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft Delete Slider.
     * @param SliderDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(SliderDestroyRequest $request): JsonResponse
    {
        try {
            return $this->sliderService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Slider: ' . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Mass delete sliders.
     */
    public function massDestroy(SliderMassDestroyRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('viewAny', Slider::class);

        return $this->executeOperation(function () use ($request) {
            $this->sliderService->massDestroy($request);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => __('strings.Deleted Successfully')
                ], 200);
            }

            return redirect()->route('backend.sliders.index')
                ->with('success', __('strings.Deleted Successfully'));
        }, 'Slider Mass Deletion');
    }

    /**
     * Reorder Slider.
     * @param Request $request
     * @return JsonResponse
     */
    public function reorder(Request $request): JsonResponse
    {
        return $this->sliderService->reorder($request);
    }

    // Archive
    /**
     * View all Sliders in Trash.
     *
     * @param SliderTrashRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function trash(SliderTrashRequest $request): View
    {
        $this->authorize('trash', Slider::class);

        return view('backend.sliders.trash', [
            'sliders' => $this->sliderService->trash($request)
        ]);
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param SliderRestoreRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(SliderRestoreRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('restore', Slider::class);

        try {
            return $this->sliderService->restore($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring Slider: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource permanently.
     *
     * @param SliderRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function remove(SliderRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Slider::class);
        try {
            return $this->sliderService->remove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing Slider: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass remove the specified resources permanently.
     *
     * @param SliderMassRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function massRemove(SliderMassRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Slider::class);
        try {
            return $this->sliderService->massRemove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass removing Slider: ' . $e->getMessage()
            ], 500);
        }
    }
}
