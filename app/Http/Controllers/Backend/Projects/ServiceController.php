<?php

namespace App\Http\Controllers\Backend\Projects;

use App\Http\Requests\Service\ServiceChangeStatusRequest;
use App\Http\Requests\Service\ServiceCreateRequest;
use App\Http\Requests\Service\ServiceDestroyRequest;
use App\Http\Requests\Service\ServiceIndexRequest;
use App\Http\Requests\Service\ServiceMassDestroyRequest;
use App\Http\Requests\Service\ServiceMassRemoveRequest;
use App\Http\Requests\Service\ServiceRemoveRequest;
use App\Http\Requests\Service\ServiceRestoreRequest;
use App\Http\Requests\Service\ServiceTrashRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Models\ServiceCategory;
use App\Services\ServiceService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Service;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ServiceController extends Controller
{
    private ServiceService $serviceService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }
    /**
     * Display a listing of the services.
     * @throws AuthorizationException
     */
    public function index(ServiceIndexRequest $request): View
    {
        $this->authorize('viewAny', Service::class);

        return view('backend.services.index', [
            'services' => $this->serviceService->index($request)
        ]);
    }

    /**
     * Change Status.
     *
     * @param ServiceChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ServiceChangeStatusRequest $request): JsonResponse
    {
        try {
            return $this->serviceService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status Service: ' . $e->getMessage()
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
        $this->authorize('create', Service::class);
        $serviceCategories = ServiceCategory::where("status", 1)->pluck('title', 'id');
        return view('backend.services.create', compact('serviceCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceCreateRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function store(ServiceCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Service::class);

        try {
            $this->serviceService->store($request);
            return redirect()->route('backend.services.index')
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating Service: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Service $service
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function show(Service $service): JsonResponse|View
    {
        $this->authorize('view', $service);

        try {
            return view('backend.services.show', [
                'service' => $this->serviceService->show($service)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the Service: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param Service $service
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function edit(Service $service): JsonResponse|View
    {
        $this->authorize('update', $service);

        try {
            $serviceCategories = ServiceCategory::where("status", 1)->pluck('title', 'id');
            return view('backend.services.edit', [
                'service' => $this->serviceService->edit($service),
                'seo' => $this->serviceService->getSeoFirst($service),
                'serviceCategories' => $serviceCategories
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the Service: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param ServiceUpdateRequest $request
     * @param Service $service
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(ServiceUpdateRequest $request, Service $service): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $service);

        try {
            $this->serviceService->update($request, $service);
            return redirect()->route('backend.services.index')
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating Service: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft Delete Service.
     * @param ServiceDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(ServiceDestroyRequest $request): JsonResponse
    {
        try {
            return $this->serviceService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Service: ' . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Mass delete services.
     */
    public function massDestroy(ServiceMassDestroyRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('viewAny', Service::class);

        return $this->executeOperation(function () use ($request) {
            $this->serviceService->massDestroy($request);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => __('strings.Deleted Successfully')
                ], 200);
            }

            return redirect()->route('backend.services.index')
                ->with('success', __('strings.Deleted Successfully'));
        }, 'Service Mass Deletion');
    }

    // Archive
    /**
     * View all services in Trash.
     *
     * @param ServiceTrashRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function trash(ServiceTrashRequest $request): View
    {
        $this->authorize('trash', Service::class);

        return view('backend.services.trash', [
            'services' => $this->serviceService->trash($request)
        ]);
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param ServiceRestoreRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(ServiceRestoreRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('restore', Service::class);

        try {
            return $this->serviceService->restore($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring Service: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource permanently.
     *
     * @param ServiceRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function remove(ServiceRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Service::class);
        try {
            return $this->serviceService->remove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing Service: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass remove the specified resources permanently.
     *
     * @param ServiceMassRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function massRemove(ServiceMassRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Service::class);
        try {
            return $this->serviceService->massRemove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass removing Service: ' . $e->getMessage()
            ], 500);
        }
    }
}
