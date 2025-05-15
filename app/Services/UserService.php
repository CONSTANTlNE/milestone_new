<?php

namespace App\Services;

use App\Contracts\UserInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UsersResource;
use App\Models\Role;
use App\Traits\ImageUploadTrait;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use DB;
use Hash;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserService implements UserInterface
{
    use MenuTrait, ImageUploadTrait, MultiTranslatableTrait;

    public function getRole()
    {
        return Role::all();
    }

    public function getSeoFirst(User $user)
    {
        return $user->seo()->first();
    }
    public function changeStatus(ChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('User');

        $user = User::find($data['id']);
        $user->update(['status' => $data['status']]);

        return  response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(UserCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('User');

        $user = new User();
        $user->setMultiTranslations($data);
        $user->status = $data['status'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->password_confirmation = $data['password_confirmation'];
        $user->save();
        if ($data['role'] != 0){
            $user->assignRole((int) $data['role']);
        }
        $this->processAndSaveImages($data, $user);
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
        Cache::forget('User');
        if(!empty($data['password'])){
            $data['confirmPassword'] = $data['password'];
            $data['password'] = Hash::make($data['password']);
        }else{
            $data['password'] = Auth::user()->password;
            $data['confirmPassword'] = Auth::user()->password;
        }
        $user->setMultiTranslations($data);
        $user->status = $data['status'];
        $user->email = $data['email'];
        $user->update($data);
        if ($data['role'] != 0){
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();
            $user->assignRole((int) $data['role']);
        }
        $this->processAndSaveImages($data, $user);
        $user->fresh();

        return response()->json([
            'user' => UserResource::make($user),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('User');
        $users = User::whereIn('id', $request->ids);
        $users->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function restore($id): void
    {
        Cache::forget('User');
        $user = User::where('id', $id)->withTrashed()->first();
        $user->restore();
        $user->fresh();
    }

    public function remove($id): JsonResponse
    {
        Cache::forget('User');
        Cache::forget('generalUser'.$id);
        Cache::forget('statusImageShowUser'.$id);
        Cache::forget('mainPdfShowUser'.$id);
        Cache::forget('defaultImageShowUser'.$id);
        $data = User::where('id', $id)->withTrashed()->first();
        $data->images()->detach();
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 204);
    }

    public function massRemove(MassRemoveRequest $request): JsonResponse
    {
        Cache::forget('User');
        $users = User::whereIn('id', $request->ids)->get();
        foreach ($users as $user) {
            Cache::forget('generalUser'.$user->id);
            Cache::forget('statusImageShowUser'.$user->id);
            Cache::forget('mainPdfShowUser'.$user->id);
            Cache::forget('defaultImageShowUser'.$user->id);
            $user->forceDelete();
            $user->images()->detach();
        }

        User::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
