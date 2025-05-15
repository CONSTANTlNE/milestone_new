<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\PersonsDataTable;
use App\DataTables\PersonsDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\Person\PersonCreateRequest;
use App\Http\Requests\Person\PersonUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Services\PersonService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Person;
use Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class PersonController extends Controller
{
    private PersonService $personService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(PersonService $personService)
    {
        $this->personService = $personService;
        $this->authorizeResource(Person::class, 'person');
    }
    /**
     * View all persons.
     *
     * @param PersonsDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(PersonsDataTable $dataTable)
    {
        $this->authorize('viewAny', Person::class);
        return $dataTable->render('backend.persons.index');
    }

    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',Person::class);
        try {
            return $this->personService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status person: ' . $e->getMessage()
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
        $this->authorize('create', Person::class);
        return view('backend.persons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PersonCreateRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(PersonCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', Person::class);
        try {
            $this->personService->store($request);
            return redirect()->route('backend.persons.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating person: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param Person $person
     * @return JsonResponse|View
     */
    public function show($lang, Person $person): JsonResponse|View
    {
        $this->authorize('view', $person);
        try {
            return view('backend.persons.show', [
                'person' => $this->personService->show($person)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the person: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param Person $person
     * @return JsonResponse|View
     */
    public function edit($lang, Person $person): JsonResponse|View
    {
        $this->authorize('update', $person);
        try {
            return view('backend.persons.edit', [
                'person' => $this->personService->edit($person),
                'seo' => $this->personService->getSeoFirst($person)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the person: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param Person $person
     * @return JsonResponse|View
     */
    public function update($lang, PersonUpdateRequest $request, Person $person): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $person);
        try {
            $this->personService->update($request, $person);
            return redirect()->route('backend.persons.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating user: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete Person.
     * @param $lang
     * @param Person $person
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, Person $person): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $person);
        try {
            $this->personService->destroy($person);
            return redirect()->route('backend.persons.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting person: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete Person.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', Person::class);
        try {
            $this->personService->massDestroy($request);
            return redirect()->route('backend.persons.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting person: ' . $e->getMessage()
            ], 500);
        }
    }

    // Archive

    /**
     * View all Persons in Trash.
     *
     * @param PersonsDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(PersonsDataTableTrash $dataTable)
    {
        $this->authorize('trash', Person::class);
        return $dataTable->render('backend.persons.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', Person::class);
        try {
            $this->personService->restore($id);
            return redirect()->route('backend.persons.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring person: ' . $e->getMessage()
            ], 500);
        }

    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Person::class);
        try {
            $this->personService->remove($id);
            return redirect()->route('backend.persons.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing person: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', Person::class);
        try {
            $this->personService->massRemove($request);
            return redirect()->route('backend.persons.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing person: ' . $e->getMessage()
            ], 500);
        }
    }
}
