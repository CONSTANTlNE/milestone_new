<?php

namespace App\Services;

use App\Contracts\UserInterface;
use App\Http\Requests\User\UserChangeStatusRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserDestroyRequest;
use App\Http\Requests\User\UserMassDestroyRequest;
use App\Http\Requests\User\UserMassRemoveRequest;
use App\Http\Requests\User\UserRemoveRequest;
use App\Http\Requests\User\UserRestoreRequest;
use App\Http\Requests\User\UserTrashRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Requests\User\UserIndexRequest;
use App\Models\Role;
use App\Traits\ImageUploadTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UserService implements UserInterface
{
    use ImageUploadTrait, MultiTranslatableTrait;

    public function index(UserIndexRequest $request): LengthAwarePaginator
    {
        return User::select(['id', 'title', 'src', 'created_at', 'status'])
            ->filter($request)
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function getRole(): \Illuminate\Database\Eloquent\Collection
    {
        return Role::all();
    }

    public function getSeoFirst(User $user)
    {
        return $user->seo()->first();
    }
    public function changeStatus(UserChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('users');

        $user = User::find($data['id']);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
                'alert-type' => 'error'
            ], 404);
        }

        $user->update(['status' => $data['status']]);

        return response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(UserCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('users');
        $user = new User();
        $user->setMultiTranslations($data);
        $user->status = $data['status'];
        $user->email = $data['email'];
        $user->name = $data['email'];
        $user->phone = $data['phone'];
        $user->password = Hash::make($data['password']);
        $user->created_at = $data['published_at'] ?? now();
        //$user->password_confirmation = $data['password_confirmation'];
        $user->save();
        if ($data['role'] != 0){
            $user->assignRole((int) $data['role']);
        }
        $this->processAndSaveImages($data, $user, true);
        $user->fresh();

        return response()->json([
            'user' => UserResource::make($user),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(User $user): JsonResponse|User
    {
        return $user;
    }

    public function edit(User $user): User
    {
        return $user;
    }

    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('users');
        $user->setMultiTranslations($data);
        $user->status = $data['status'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->created_at = $data['published_at'] ?? now();

        if(!empty($data['password'])){
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        if ($data['role'] != 0){
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $user->assignRole((int) $data['role']);
        }
        $this->processAndSaveImages($data, $user, true);
        $user->fresh();

        return response()->json([
            'user' => UserResource::make($user),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(UserDestroyRequest $request): JsonResponse
    {
        Cache::forget('users');
        $user = User::find($request->id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
                'alert-type' => 'error'
            ], 404);
        }
        $user->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function massDestroy(UserMassDestroyRequest $request): JsonResponse
    {
        Cache::forget('users');
        User::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

// Archive Function Method
    public function trash(UserTrashRequest $request): LengthAwarePaginator
    {
        return User::select(['id', 'title', 'created_at'])
            ->filterTrash($request)
            ->paginate($request->input('per_page', 10))
            ->appends($request->query());
    }

    public function restore(UserRestoreRequest $request): JsonResponse
    {
        Cache::forget('users');
        $user = User::where('id', $request->id)->withTrashed()->first();
        $user->restore();
        $user->fresh();

        return response()->json([
            'message' => __('strings.Restored Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function remove(UserRemoveRequest $request): JsonResponse
    {
        Cache::forget('users');
        $pageId = $request->id;
        $data = User::where('id', $pageId)->withTrashed()->first();
        $data->images()->detach();
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }

    public function massRemove(UserMassRemoveRequest $request): JsonResponse
    {
        Cache::forget('users');
        $users = User::withTrashed()->whereIn('id', $request->ids)->get();

        foreach ($users as $user) {
            $user->images()->detach();
        }

        User::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Mass Deleted Successfully from Archive'),
            'alert-type' => 'success'
        ]);
    }
}
