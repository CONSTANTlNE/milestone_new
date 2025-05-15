<?php

namespace App\Http\Controllers\Backend;

use App\Contracts\DataInterface;
use App\DataTables\DatasDataTable;
use App\DataTables\DatasDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\Data\DataCreateRequest;
use App\Http\Requests\Data\DataUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Services\DataService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Data;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class DataController extends Controller
{
    private DataService $dataService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
        $this->authorizeResource(Data::class, 'data');
    }
    /**
     * View all data.
     *
     * @param DatasDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(DatasDataTable $dataTable)
    {
        $this->authorize('viewAny', Data::class);
        return $dataTable->render('backend.data.index');
    }

    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',Data::class);
        try {
            return $this->dataService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status data: ' . $e->getMessage()
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
        $this->authorize('create', Data::class);
        return view('backend.data.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DataCreateRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(DataCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Data::class);
        try {
            $this->dataService->store($request);
            return redirect()->route('backend.data.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param Data $data
     * @return JsonResponse|View
     */
    public function show($lang, Data $data): JsonResponse|View
    {
        $this->authorize('view', $data);
        try {
            return view('backend.data.show', [
                'data' => $this->dataService->show($data)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param Data $data
     * @return JsonResponse|View
     */
    public function edit($lang, Data $data): JsonResponse|View
    {
        $this->authorize('update', $data);
        try {
            return view('backend.data.edit', [
                'data' => $this->dataService->edit($data),
                'seo' => $this->dataService->getSeoFirst($data)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the data: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param Data $data
     * @return JsonResponse|View
     */
    public function update($lang, DataUpdateRequest $request, Data $data): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $data);
        try {
            $this->dataService->update($request, $data);
            return redirect()->route('backend.data.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating user: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Data.
     * @param $lang
     * @param Data $data
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, Data $data): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $data);
        try {
            $this->dataService->destroy($data);
            return redirect()->route('backend.data.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Data.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', Data::class);
        try {
            $this->dataService->massDestroy($request);
            return redirect()->route('backend.data.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting data: ' . $e->getMessage()
            ], 500);
        }
    }

    // Archive

    /**
     * View all Datas in Trash.
     *
     * @param DatasDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(DatasDataTableTrash $dataTable)
    {
        $this->authorize('trash', Data::class);
        return $dataTable->render('backend.data.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Data::class);
        try {
            $this->dataService->restore($id);
            return redirect()->route('backend.data.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring data: ' . $e->getMessage()
            ], 500);
        }

    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Data::class);
        try {
            $this->dataService->remove($id);
            return redirect()->route('backend.data.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Data::class);
        try {
            $this->dataService->massRemove($request);
            return redirect()->route('backend.data.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing data: ' . $e->getMessage()
            ], 500);
        }
    }
}
