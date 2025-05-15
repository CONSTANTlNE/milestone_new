<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Requests\Social\SocialCreateRequest;
use App\Http\Requests\Social\SocialUpdateRequest;
use App\Models\Social;
use App\Services\SocialService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

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
        $this->authorizeResource(Social::class, 'social');
    }

    /**
     * View all Social Icons.
     *
     * @return JsonResponse|View
     */
    public function index(): JsonResponse|View
    {
        $this->authorize('viewAny', Social::class);
        try {
            return view('backend.socials.index', [
                'socials' => $this->socialService->getSocial()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while retrieve social icons: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',Social::class);
        try {
            return $this->socialService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status social icons: ' . $e->getMessage()
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
        $this->authorize('create', Social::class);
        return view('backend.socials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SocialCreateRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(SocialCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Social::class);
        try {
            $this->socialService->store($request);
            return redirect()->route('backend.socials.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating social icons: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param Social $social
     * @return JsonResponse|View
     */
    public function show($lang, Social $social): JsonResponse|View
    {
        $this->authorize('view', $social);
        try {
            return view('backend.socials.show', [
                'social' => $this->socialService->show($social)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the social icons: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param Social $social
     * @return JsonResponse|View
     */
    public function edit($lang, Social $social): JsonResponse|View
    {
        $this->authorize('update', $social);
        try {
            return view('backend.socials.edit', [
                'social' => $this->socialService->edit($social),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the social icons: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param SocialUpdateRequest $request
     * @param Social $social
     * @return JsonResponse|View
     */
    public function update($lang, SocialUpdateRequest $request, Social $social): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $social);
        try {
            $this->socialService->update($request, $social);
            return redirect()->route('backend.socials.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating social: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Social.
     * @param $lang
     * @param Social $social
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, Social $social): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $social);
        try {
            $this->socialService->destroy($social);
            return redirect()->route('backend.socials.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting social icons: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Social.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', Social::class);
        try {
            $this->socialService->massDestroy($request);
            return redirect()->route('backend.socials.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting social icons: ' . $e->getMessage()
            ], 500);
        }
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
     * View all Social Icons in Trash.
     *
     * @return JsonResponse|View
     */

    public function trash(): JsonResponse|View
    {
        $this->authorize('trash', Social::class);
        try {
            return view('backend.socials.trash', [
                'socials' => $this->socialService->getSocialTrash()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while retrieve social icons: ' . $e->getMessage()
            ], 500);
        }
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Page::class);
        try {
            $this->socialService->restore($id);
            return redirect()->route('backend.socials.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring social icons: ' . $e->getMessage()
            ], 500);
        }
    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Social::class);
        try {
            $this->socialService->remove($id);
            return redirect()->route('backend.socials.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing social icons: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Social::class);
        try {
            $this->socialService->massRemove($request);
            return redirect()->route('backend.socials.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing social icons: ' . $e->getMessage()
            ], 500);
        }
    }
}
