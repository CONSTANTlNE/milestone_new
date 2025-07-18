<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Locale\LocaleChangeStatusRequest;
use App\Http\Requests\Locale\LocaleCreateRequest;
use App\Http\Requests\Locale\LocaleDestroyRequest;
use App\Http\Requests\Locale\LocaleIndexRequest;
use App\Http\Requests\Locale\LocaleMassDestroyRequest;
use App\Http\Requests\Locale\LocaleMassRemoveRequest;
use App\Http\Requests\Locale\LocaleRemoveRequest;
use App\Http\Requests\Locale\LocaleRestoreRequest;
use App\Http\Requests\Locale\LocaleTrashRequest;
use App\Http\Requests\Locale\LocaleUpdateRequest;
use App\Services\LocaleService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Locale;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LocaleController extends Controller
{
    private LocaleService $localeService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(LocaleService $localeService)
    {
        $this->localeService = $localeService;
    }
    /**
     * Display a listing of the locales.
     * @throws AuthorizationException
     */
    public function index(LocaleIndexRequest $request): View
    {
        $this->authorize('viewAny', Locale::class);

        return view('backend.locales.index', [
            'locales' => $this->localeService->index($request)
        ]);
    }

    /**
     * Change Status.
     *
     * @param LocaleChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(LocaleChangeStatusRequest $request): JsonResponse
    {
        try {

            return $this->localeService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status Locale: ' . $e->getMessage()
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
        $this->authorize('create', Locale::class);
        return view('backend.locales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LocaleCreateRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function store(LocaleCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Locale::class);

        try {
            $this->localeService->store($request);
            return redirect()->route('backend.locales.index')
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating Locale: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Locale $locale
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function show(Locale $locale): JsonResponse|View
    {
        $this->authorize('view', $locale);

        try {
            return view('backend.locales.show', [
                'locale' => $this->localeService->show($locale)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the Locale: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param Locale $locale
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function edit(Locale $locale): JsonResponse|View
    {
        $this->authorize('update', $locale);

        try {
            return view('backend.locales.edit', [
                'locale' => $this->localeService->edit($locale)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the Locale: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param LocaleUpdateRequest $request
     * @param Locale $locale
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(LocaleUpdateRequest $request, Locale $locale): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $locale);

        try {
            $this->localeService->update($request, $locale);
            return redirect()->route('backend.locales.index')
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating Locale: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft Delete Locale.
     * @param LocaleDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(LocaleDestroyRequest $request): JsonResponse
    {
        try {
            return $this->localeService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Locale: ' . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Mass delete locales.
     */
    public function massDestroy(LocaleMassDestroyRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('viewAny', Locale::class);

        return $this->executeOperation(function () use ($request) {
            $this->localeService->massDestroy($request);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => __('strings.Deleted Successfully')
                ], 200);
            }

            return redirect()->route('backend.locales.index')
                ->with('success', __('strings.Deleted Successfully'));
        }, 'Locale Mass Deletion');
    }


    /**
     * Reorder Locale.
     * @param Request $request
     * @return JsonResponse
     */
    public function reorder(Request $request): JsonResponse
    {
        return $this->localeService->reorder($request);
    }

    // Archive
    /**
     * View all locales in Trash.
     *
     * @param LocaleTrashRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function trash(LocaleTrashRequest $request): View
    {
        $this->authorize('trash', Locale::class);

        return view('backend.locales.trash', [
            'locales' => $this->localeService->trash($request)
        ]);
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param LocaleRestoreRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(LocaleRestoreRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('restore', Locale::class);

        try {
            return $this->localeService->restore($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring Locale: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource permanently.
     *
     * @param LocaleRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function remove(LocaleRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Locale::class);
        try {
            return $this->localeService->remove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing Locale: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass remove the specified resources permanently.
     *
     * @param LocaleMassRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function massRemove(LocaleMassRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Locale::class);
        try {
            return $this->localeService->massRemove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass removing Locale: ' . $e->getMessage()
            ], 500);
        }
    }
}
