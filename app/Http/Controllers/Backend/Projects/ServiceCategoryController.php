<?php

namespace App\Http\Controllers\Backend\Projects;

use App\Http\Requests\ServiceCategory\ServiceCategoryChangeStatusRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryCreateRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryDestroyRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryIndexRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryMassDestroyRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryMassRemoveRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryRemoveRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryRestoreRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryTrashRequest;
use App\Http\Requests\ServiceCategory\ServiceCategoryUpdateRequest;
use App\Services\ServiceCategoryService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\ServiceCategory;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ServiceCategoryController extends Controller
{
    private ServiceCategoryService $serviceCategoryService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(ServiceCategoryService $serviceCategoryService)
    {
        $this->serviceCategoryService = $serviceCategoryService;
    }

    /**
     * Display a listing of the serviceCategories.
     * @throws AuthorizationException
     */
    public function index(ServiceCategoryIndexRequest $request): View
    {
        $this->authorize('viewAny', ServiceCategory::class);

        return view('backend.serviceCategories.index', [
            'serviceCategories' => $this->serviceCategoryService->index($request)
        ]);
    }

    /**
     * Change Status.
     *
     * @param ServiceCategoryChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ServiceCategoryChangeStatusRequest $request): JsonResponse
    {
        try {
            return $this->serviceCategoryService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status ServiceCategory: ' . $e->getMessage()
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
        $this->authorize('create', ServiceCategory::class);
        return view('backend.serviceCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceCategoryCreateRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function store(ServiceCategoryCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', ServiceCategory::class);

        try {
            $this->serviceCategoryService->store($request);
            return redirect()->route('backend.serviceCategories.index')
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating ServiceCategory: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param ServiceCategory $serviceCategory
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function show(ServiceCategory $serviceCategory): JsonResponse|View
    {
        $this->authorize('view', $serviceCategory);

        try {
            return view('backend.serviceCategories.show', [
                'serviceCategory' => $this->serviceCategoryService->show($serviceCategory)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the ServiceCategory: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param ServiceCategory $serviceCategory
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function edit(ServiceCategory $serviceCategory): JsonResponse|View
    {
        $this->authorize('update', $serviceCategory);

        try {
            return view('backend.serviceCategories.edit', [
                'serviceCategory' => $this->serviceCategoryService->edit($serviceCategory),
                'seo' => $this->serviceCategoryService->getSeoFirst($serviceCategory)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the ServiceCategory: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param ServiceCategoryUpdateRequest $request
     * @param ServiceCategory $serviceCategory
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(ServiceCategoryUpdateRequest $request, ServiceCategory $serviceCategory): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $serviceCategory);

        try {
            $this->serviceCategoryService->update($request, $serviceCategory);
            return redirect()->route('backend.serviceCategories.index')
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating ServiceCategory: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft Delete ServiceCategory.
     * @param ServiceCategoryDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(ServiceCategoryDestroyRequest $request): JsonResponse
    {
        try {
            return $this->serviceCategoryService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting ServiceCategory: ' . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Mass delete ServiceCategories.
     */
    public function massDestroy(ServiceCategoryMassDestroyRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('viewAny', ServiceCategory::class);

        return $this->executeOperation(function () use ($request) {
            $this->serviceCategoryService->massDestroy($request);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => __('strings.Deleted Successfully')
                ], 200);
            }

            return redirect()->route('backend.serviceCategories.index')
                ->with('success', __('strings.Deleted Successfully'));
        }, 'ServiceCategory Mass Deletion');
    }

    // Archive
    /**
     * View all ServiceCategory in Trash.
     *
     * @param ServiceCategoryTrashRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function trash(ServiceCategoryTrashRequest $request): View
    {
        $this->authorize('trash', ServiceCategory::class);

        return view('backend.serviceCategories.trash', [
            'serviceCategories' => $this->serviceCategoryService->trash($request)
        ]);
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param ServiceCategoryRestoreRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(ServiceCategoryRestoreRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('restore', ServiceCategory::class);

        try {
            return $this->serviceCategoryService->restore($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring ServiceCategory: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource permanently.
     *
     * @param ServiceCategoryRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function remove(ServiceCategoryRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', ServiceCategory::class);
        try {
            return $this->serviceCategoryService->remove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing ServiceCategory: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass remove the specified resources permanently.
     *
     * @param ServiceCategoryMassRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function massRemove(ServiceCategoryMassRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', ServiceCategory::class);
        try {
            return $this->serviceCategoryService->massRemove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass removing ServiceCategory: ' . $e->getMessage()
            ], 500);
        }
    }
}
