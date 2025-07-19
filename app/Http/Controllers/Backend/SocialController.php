<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Social\SocialChangeStatusRequest;
use App\Http\Requests\Social\SocialCreateRequest;
use App\Http\Requests\Social\SocialDestroyRequest;
use App\Http\Requests\Social\SocialIndexRequest;
use App\Http\Requests\Social\SocialMassDestroyRequest;
use App\Http\Requests\Social\SocialMassRemoveRequest;
use App\Http\Requests\Social\SocialRemoveRequest;
use App\Http\Requests\Social\SocialRestoreRequest;
use App\Http\Requests\Social\SocialTrashRequest;
use App\Http\Requests\Social\SocialUpdateRequest;
use App\Services\SocialService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Social;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SocialController extends Controller
{
    private SocialService $socialService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(SocialService $socialService)
    {
        $this->socialService = $socialService;
    }
    /**
     * Display a listing of the Socials.
     * @throws AuthorizationException
     */
    public function index(SocialIndexRequest $request): View
    {
        $this->authorize('viewAny', Social::class);

        return view('backend.socials.index', [
            'socials' => $this->socialService->index($request)
        ]);
    }

    /**
     * Change Status.
     *
     * @param SocialChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(SocialChangeStatusRequest $request): JsonResponse
    {
        try {
            return $this->socialService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status Social: ' . $e->getMessage()
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
        $this->authorize('create', Social::class);
        return view('backend.socials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SocialCreateRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function store(SocialCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Social::class);

        try {
            $this->socialService->store($request);
            return redirect()->route('backend.socials.index')
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating Social: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Social $social
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function show(Social $social): JsonResponse|View
    {
        $this->authorize('view', $social);

        try {
            return view('backend.socials.show', [
                'social' => $this->socialService->show($social)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the Social: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param Social $social
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function edit(Social $social): JsonResponse|View
    {
        $this->authorize('update', $social);

        try {
            return view('backend.socials.edit', [
                'social' => $this->socialService->edit($social)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the Social: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param SocialUpdateRequest $request
     * @param Social $social
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(SocialUpdateRequest $request, Social $social): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $social);

        try {
            $this->socialService->update($request, $social);
            return redirect()->route('backend.socials.index')
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating Social: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft Delete Social.
     * @param SocialDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(SocialDestroyRequest $request): JsonResponse
    {
        try {
            return $this->socialService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Social: ' . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Mass delete socials.
     */
    public function massDestroy(SocialMassDestroyRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('viewAny', Social::class);

        return $this->executeOperation(function () use ($request) {
            $this->socialService->massDestroy($request);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => __('strings.Deleted Successfully')
                ], 200);
            }

            return redirect()->route('backend.socials.index')
                ->with('success', __('strings.Deleted Successfully'));
        }, 'Social Mass Deletion');
    }


    /**
     * Reorder Social.
     * @return JsonResponse
     */
    public function reorder(Request $request)
    {
        return $this->socialService->reorder($request);
    }

    // Archive
    /**
     * View all socials in Trash.
     *
     * @param SocialTrashRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function trash(SocialTrashRequest $request): View
    {
        $this->authorize('trash', Social::class);

        return view('backend.socials.trash', [
            'socials' => $this->socialService->trash($request)
        ]);
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param SocialRestoreRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(SocialRestoreRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('restore', Social::class);

        try {
            return $this->socialService->restore($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring Social: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource permanently.
     *
     * @param SocialRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function remove(SocialRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Social::class);
        try {
            return $this->socialService->remove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing Social: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass remove the specified resources permanently.
     *
     * @param SocialMassRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function massRemove(SocialMassRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Social::class);
        try {
            return $this->socialService->massRemove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass removing Social: ' . $e->getMessage()
            ], 500);
        }
    }
}
