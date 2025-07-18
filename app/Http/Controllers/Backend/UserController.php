<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\User\UserChangeStatusRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserDestroyRequest;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserMassDestroyRequest;
use App\Http\Requests\User\UserMassRemoveRequest;
use App\Http\Requests\User\UserRemoveRequest;
use App\Http\Requests\User\UserRestoreRequest;
use App\Http\Requests\User\UserTrashRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class UserController extends Controller
{
    private UserService $userService;

    /**
     * Create the controller instance.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the users.
     */
    public function index(UserIndexRequest $request): View
    {
        $this->authorize('viewAny', User::class);

        return view('backend.users.index', [
            'users' => $this->userService->index($request)
        ]);
    }

    /**
     * Change user status.
     */
    public function status(UserChangeStatusRequest $request): JsonResponse
    {
        try {
            return $this->userService->changeStatus($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while change status User: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        $this->authorize('create', User::class);
        return view('backend.users.create', [
            'roles' => $this->userService->getRole()
        ]);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(UserCreateRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('create', User::class);

        try {
            $this->userService->store($request);
            return redirect()->route('backend.users.index')
                ->with('success', __('strings.Added Successfully'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed while creating User: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): JsonResponse|View
    {
        $this->authorize('view', $user);

        try {
            return view('backend.users.show', [
                'user' => $this->userService->show($user),
                'roles' => $this->userService->getRole()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve the User: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): JsonResponse|View
    {
        $this->authorize('update', $user);

        try {
            return view('backend.users.edit', [
                'user' => $this->userService->edit($user),
                'roles' => $this->userService->getRole()
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to editing the User: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the specified user in storage.
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse|RedirectResponse
    {
        $this->authorize('update', $user);

        try {
            $this->userService->update($request, $user);
            return redirect()->route('backend.users.index')
                ->with('success', __('strings.Updated Successfully'));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while updating User: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(UserDestroyRequest $request): JsonResponse
    {
        try {
            return $this->userService->destroy($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while deleting User: ' . $e->getMessage()
            ], 500);
        }

    }

    /**
     * Mass delete users.
     */
    public function massDestroy(UserMassDestroyRequest $request): RedirectResponse|JsonResponse
    {
        $this->authorize('viewAny', User::class);

        return $this->executeOperation(function () use ($request) {
            $this->userService->massDestroy($request);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'message' => __('strings.Deleted Successfully')
                ], 200);
            }

            return redirect()->route('backend.users.index')
                ->with('success', __('strings.Deleted Successfully'));
        }, 'User Mass Deletion');
    }

    // Archive Methods
    /**
     * View all Users in Trash.
     *
     * @param UserTrashRequest $request
     * @return mixed
     * @throws AuthorizationException
     */
    public function trash(UserTrashRequest $request): View
    {
        $this->authorize('trash', User::class);

        return view('backend.users.trash', [
            'users' => $this->userService->trash($request)
        ]);
    }

    /**
     * Restore a soft deleted user.
     */
    public function restore(UserRestoreRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('restore', User::class);

        try {
            return $this->userService->restore($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while restoring User: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Permanently delete a user from trash.
     */
    public function remove(UserRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', User::class);
        try {
            return $this->userService->remove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while removing User: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Mass permanently delete users from trash.
     */
    public function massRemove(UserMassRemoveRequest $request): JsonResponse|RedirectResponse
    {
        $this->authorize('remove', User::class);
        try {
            return $this->userService->massRemove($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed while mass removing User: ' . $e->getMessage()
            ], 500);
        }
    }
}
