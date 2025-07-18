<?php

namespace App\Http\Controllers\Backend\Projects;

use App\Http\Requests\Faq\FaqChangeStatusRequest;
use App\Http\Requests\Faq\FaqCreateRequest;
use App\Http\Requests\Faq\FaqDestroyRequest;
use App\Http\Requests\Faq\FaqIndexRequest;
use App\Http\Requests\Faq\FaqMassDestroyRequest;
use App\Http\Requests\Faq\FaqMassRemoveRequest;
use App\Http\Requests\Faq\FaqRemoveRequest;
use App\Http\Requests\Faq\FaqRestoreRequest;
use App\Http\Requests\Faq\FaqTrashRequest;
use App\Http\Requests\Faq\FaqUpdateRequest;
use App\Services\FaqService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Faq;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class FaqController extends Controller
{
    private FaqService $faqService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;
    }
    /**
     * Display a listing of the faqs.
     * @throws AuthorizationException
     */
    public function index(FaqIndexRequest $request): View
    {
        $this->authorize('viewAny', Faq::class);

        return view('backend.faqs.index', [
            'faqs' => $this->faqService->index($request)
        ]);
    }

    /**
     * Change Status.
     *
     * @param FaqChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(FaqChangeStatusRequest $request): JsonResponse
    {
        try {
            return $this->faqService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status Faq: ' . $e->getMessage()
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
        $this->authorize('create', Faq::class);
        return view('backend.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FaqCreateRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function store(FaqCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Faq::class);

        try {
            $this->faqService->store($request);
            return redirect()->route('backend.faqs.index')
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating Faq: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Faq $faq
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function show(Faq $faq): JsonResponse|View
    {
        $this->authorize('view', $faq);

        try {
            return view('backend.faqs.show', [
                'faq' => $this->faqService->show($faq)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the Faq: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param Faq $faq
     * @return JsonResponse|View
     * @throws AuthorizationException
     */
    public function edit(Faq $faq): JsonResponse|View
    {
        $this->authorize('update', $faq);

        try {
            return view('backend.faqs.edit', [
                'faq' => $this->faqService->edit($faq)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the Faq: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param FaqUpdateRequest $request
     * @param Faq $faq
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function update(FaqUpdateRequest $request, Faq $faq): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $faq);

        try {
            $this->faqService->update($request, $faq);
            return redirect()->route('backend.faqs.index')
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating Faq: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Soft Delete Faq.
     * @param FaqDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(FaqDestroyRequest $request): JsonResponse
    {
        try {
            return $this->faqService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting Faq: ' . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Mass delete faqs.
     */
    public function massDestroy(FaqMassDestroyRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('viewAny', Faq::class);

        return $this->executeOperation(function () use ($request) {
            $this->faqService->massDestroy($request);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => __('strings.Deleted Successfully')
                ], 200);
            }

            return redirect()->route('backend.faqs.index')
                ->with('success', __('strings.Deleted Successfully'));
        }, 'Faq Mass Deletion');
    }

    // Archive
    /**
     * View all Faqs in Trash.
     *
     * @param FaqTrashRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function trash(FaqTrashRequest $request): View
    {
        $this->authorize('trash', Faq::class);

        return view('backend.faqs.trash', [
            'faqs' => $this->faqService->trash($request)
        ]);
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param FaqRestoreRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function restore(FaqRestoreRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('restore', Faq::class);

        try {
            return $this->faqService->restore($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring Faq: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource permanently.
     *
     * @param FaqRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function remove(FaqRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Faq::class);
        try {
            return $this->faqService->remove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing Faq: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass remove the specified resources permanently.
     *
     * @param FaqMassRemoveRequest $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function massRemove(FaqMassRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Faq::class);
        try {
            return $this->faqService->massRemove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass removing Faq: ' . $e->getMessage()
            ], 500);
        }
    }
}
