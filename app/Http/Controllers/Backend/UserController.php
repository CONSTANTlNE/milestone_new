<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\UsersDataTable;
use App\DataTables\UsersDataTableTrash;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;

class UserController extends Controller
{
    private UserService $userService;

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * View all Users.
     *
     * @param UsersDataTable $dataTable
     * @return View
     */
    #[NoReturn] public function index(UsersDataTable $dataTable)
    {
        $this->authorize('viewAny', User::class);
        return $dataTable->render('backend.users.index');
    }

    /**
     * Change Status.
     *
     * @param ChangeStatusRequest $request
     * @return JsonResponse
     */
    public function status(ChangeStatusRequest $request): JsonResponse
    {
        $this->authorize('status',User::class);
        try {
            return $this->userService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status user: ' . $e->getMessage()
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
        $this->authorize('create', User::class);
        return view('backend.users.create', [
            'roles' => $this->userService->getRole()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserCreateRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function store(UserCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', User::class);
        try {
            $this->userService->store($request);
            return redirect()->route('backend.users.index', app()->getLocale())
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $lang
     * @param User $user
     * @return JsonResponse|View
     */
    public function show($lang, User $user): JsonResponse|View
    {
        $this->authorize('view', $user);
        try {
            return view('backend.users.show', [
                'user' => $this->userService->show($user),
                'roles' => $this->userService->getRole()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param $lang
     * @param User $user
     * @return JsonResponse|View
     */
    public function edit($lang, User $user): JsonResponse|View
    {
        $this->authorize('update', $user);
        try {
            return view('backend.users.edit', [
                'user' => $this->userService->edit($user),
                'roles' => $this->userService->getRole()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param $lang
     * @param UserUpdateRequest $request
     * @param User $user
     * @return JsonResponse|View
     */
    public function update($lang, UserUpdateRequest $request, User $user): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $user);
        try {
            $this->userService->update($request, $user);
            return redirect()->route('backend.users.index', app()->getLocale())
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating user: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Soft Delete User.
     * @param $lang
     * @param User $user
     * @return JsonResponse|RedirectResponse
     */
    public function destroy($lang, User $user): JsonResponse|RedirectResponse
    {
        $this->authorize('delete', $user);
        try {
            $this->userService->destroy($user);
            return redirect()->route('backend.users.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mass Soft Delete User.
     * @param MassDestroyRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function massDestroy(MassDestroyRequest $request)
    {
        $this->authorize('delete', User::class);
        try {
            $this->userService->massDestroy($request);
            return redirect()->route('backend.users.index', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass deleting user: ' . $e->getMessage()
            ], 500);
        }
    }

    // Archive
    /**
     * View all Users in Trash.
     *
     * @param UsersDataTableTrash $dataTable
     * @return mixed
     */
    #[NoReturn] public function trash(UsersDataTableTrash $dataTable)
    {
        $this->authorize('trash', User::class);
        return $dataTable->render('backend.users.trash');
    }

    public function restore($lang, $id)
    {
        $this->authorize('restore', User::class);
        try {
            $this->userService->restore($id);
            return redirect()->route('backend.users.trash', app()->getLocale())
                ->with('success', __('strings.Restored Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring user: ' . $e->getMessage()
            ], 500);
        }

    }

    public function remove($lang, $id): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', User::class);
        try {
            $this->userService->remove($id);
            return redirect()->route('backend.users.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function massRemove(MassDestroyRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', User::class);
        try {
            $this->userService->massRemove($request);
            return redirect()->route('backend.users.trash', app()->getLocale())
                ->with('success', __('strings.Deleted Successfully from Archive'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass Removing user: ' . $e->getMessage()
            ], 500);
        }
    }
}
