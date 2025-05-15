<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\Locale\LocaleCreateRequest;
use App\Http\Requests\Locale\LocaleUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Locale;
use App\Services\LocaleService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

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
        $this->authorizeResource(Locale::class, 'locale');
    }

    /**
     * View all Locales.
     *
     * @return JsonResponse|View
     */
    public function index(): JsonResponse|View
    {
        $this->authorize('viewAny', Locale::class);
        try {
            return view('backend.locales.index', [
                'locales' => $this->localeService->getLocales()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while retrieve Locales: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change Status.
     *
     * @param $lang
     * @param Locale $locale
     * @return RedirectResponse|JsonResponse
     */
    public function status($lang, Locale $locale): RedirectResponse|JsonResponse
    {
        $this->authorize('status', $locale);
        try {
            $this->localeService->changeStatus($locale);
            return redirect()->route('backend.locales.index', app()->getLocale())
                ->with('success', __('strings.Status changed successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status Locales: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Change General Locale.
     */
    public function general($lang, Locale $locale): RedirectResponse|JsonResponse
    {
        $this->authorize('status', $locale);
        try {
            $this->localeService->general($locale);
            return redirect()->route('backend.locales.index', app()->getLocale())
                ->with('success', __('strings.Status changed successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status Locales: ' . $e->getMessage()
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
        $this->authorize('create', Locale::class);
        return view('backend.locales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LocaleCreateRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(LocaleCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Locale::class);
        try {
            $this->localeService->store($request);
            return redirect()->route('backend.locales.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating Locales: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param Locale $locale
     * @return JsonResponse|View
     */
    public function show($lang, Locale $locale): JsonResponse|View
    {
        $this->authorize('view', $locale);
        try {
            return view('backend.locales.show', [
                'locale' => $this->localeService->show($locale)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the Locales: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param Locale $locale
     * @return JsonResponse|View
     */
    public function edit($lang, Locale $locale): JsonResponse|View
    {
        $this->authorize('update', $locale);
        try {
            return view('backend.locales.edit', [
                'locale' => $this->localeService->edit($locale),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the Locales: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param LocaleUpdateRequest $request
     * @param Locale $locale
     * @return JsonResponse|View
     */
    public function update($lang, LocaleUpdateRequest $request, Locale $locale): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $locale);
        try {
            $this->localeService->update($request, $locale);
            return redirect()->route('backend.locales.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating Locales: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Locale.
     * @param $lang
     * @param Locale $locale
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, Locale $locale): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $locale);
        try {
            $this->localeService->destroy($locale);
            return redirect()->route('backend.locales.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Locales: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Locale.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', Locale::class);
        try {
            $this->localeService->massDestroy($request);
            return redirect()->route('backend.locales.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting Locales: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reorder Locale.
     * @return JsonResponse
     */
    public function reorder(Request $request)
    {
        return $this->localeService->reorder($request);
    }

    // Archive
    /**
     * View all Locales in Trash.
     *
     * @return JsonResponse|View
     */

    public function trash(): JsonResponse|View
    {
        $this->authorize('trash', Locale::class);
        try {
            return view('backend.locales.trash', [
                'locales' => $this->localeService->getLocaleTrash()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while retrieve Locales: ' . $e->getMessage()
            ], 500);
        }
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Locale::class);
        try {
            $this->localeService->restore($id);
            return redirect()->route('backend.locales.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring Locales: ' . $e->getMessage()
            ], 500);
        }
    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Locale::class);
        try {
            $this->localeService->remove($id);
            return redirect()->route('backend.locales.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing Locales: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Locale::class);
        try {
            $this->localeService->massRemove($request);
            return redirect()->route('backend.locales.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing Locales: ' . $e->getMessage()
            ], 500);
        }
    }
}
