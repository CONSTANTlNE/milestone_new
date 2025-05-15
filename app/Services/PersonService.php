<?php

namespace App\Services;

use App\Contracts\PersonInterface;
use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\Person\PersonCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Person\PersonUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Http\Resources\Person\PersonResource;
use App\Http\Resources\Person\PersonsResource;
use App\Traits\ImageUploadTrait;
use App\Traits\MenuTrait;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\JsonResponse;
use App\Models\Person;
use Illuminate\Support\Facades\Cache;

class PersonService implements PersonInterface
{
    use MenuTrait, ImageUploadTrait, MultiTranslatableTrait;
    const CACHE_TTL = 86400; // 1 day

    public function getPersons()
    {
        if (Cache::has('Person')){
            $persons = Cache::get('Person');
        } else {
            $persons = Cache::remember('Person', self::CACHE_TTL, function (){
                return Person::all();
            });
        }
        return $persons;
    }

    public function getSeoFirst(Person $person)
    {
        return $person->seo()->first();
    }
    public function changeStatus(ChangeStatusRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Person');

        $person = Person::find($data['id']);
        $person->update(['status' => $data['status']]);

        $person->setActive($data['status']);

        return  response()->json([
            'message' => __('strings.Status changed successfully'),
            'alert-type' => 'success'
        ]);
    }

    public function store(PersonCreateRequest $request): JsonResponse
    {
        $data = $request->validated();
        Cache::forget('Person');

        $person = new Person();
        $person->setMultiTranslations($data);
        $person->status = $data['status'];
        $person->type = $data['type'];
        $person->save();
        // Set SEO translations if available
        $person->setSeoTranslations($data);
        $this->processAndSaveImages($data, $person);
        $person->fresh();

        return response()->json([
            'person' => PersonResource::make($person),
            'message' => __('strings.Added Successfully')
        ], 201);
    }

    public function show(Person $person): JsonResponse|Person
    {
        return $person;
    }

    public function edit(Person $person): Person
    {
        return $person;
    }

    public function update(PersonUpdateRequest $request, Person $person): JsonResponse
    {
        $data = $request->validated();

        Cache::forget('Person');
        $person->setMultiTranslations($data);
        $person->status = $data['status'];
        $person->type = $data['type'];
        $person->save();
        // Set Menu translations if available
        $person->setMenuTranslations(
            $person->getTranslations('title'),
            $person->getTranslations('slug')
        );
        $person->setActive($data['status']);
        // Set SEO translations if available
        $person->setSeoTranslations($data);
        $this->processAndSaveImages($data, $person);
        $person->fresh();

        return response()->json([
            'person' => PersonResource::make($person),
            'message' => __('strings.Updated Successfully')
        ], 201);
    }

    public function destroy(Person $person): JsonResponse
    {
        $person->setActive(false);
        $person->delete();

        return response()->json([
            'message' => __('strings.Deleted Successfully'),
        ], 204);
    }

    public function massDestroy(MassDestroyRequest $request): JsonResponse
    {
        Cache::forget('Person');
        $persons = Person::whereIn('id', $request->ids);
        foreach ($persons as $person) {
            $person->setActive(false);
        }
        $persons->delete();
        return response()->json([
            'message' => __('strings.massDestroy Successfully'),
        ], 204);
    }

    // Archive Function Method
    public function restore($id): void
    {
        Cache::forget('Person');
        $person = Person::where('id', $id)->withTrashed()->first();
        $person->restore();
        $person->setActive(false);
        $person->fresh();
    }

    public function remove($id): JsonResponse
    {
        Cache::forget('Person');
        $data = Person::where('id', $id)->withTrashed()->first();
        $data->seo()->forceDelete();
        $data->images()->detach();
        $data->setForceDelete(true);
        $data->forceDelete();
        $data->fresh();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 204);
    }

    public function massRemove(MassRemoveRequest $request): JsonResponse
    {
        Cache::forget('Person');
        $persons = Person::whereIn('id', $request->ids)->get();
        foreach ($persons as $person) {
            $person->seo()->forceDelete();
            $person->setForceDelete(true);
            $person->images()->detach();
        }

        Person::whereIn('id', $request->ids)->withTrashed()->forceDelete();

        return response()->json([
            'message' => __('strings.Deleted Successfully from Archive'),
        ], 200);
    }
}
