<?php
namespace App\Contracts;

use App\Http\Requests\Slider\SliderChangeStatusRequest;
use App\Http\Requests\Slider\SliderCreateRequest;
use App\Http\Requests\Slider\SliderDestroyRequest;
use App\Http\Requests\Slider\SliderIndexRequest;
use App\Http\Requests\Slider\SliderMassDestroyRequest;
use App\Http\Requests\Slider\SliderMassRemoveRequest;
use App\Http\Requests\Slider\SliderRemoveRequest;
use App\Http\Requests\Slider\SliderRestoreRequest;
use App\Http\Requests\Slider\SliderTrashRequest;
use App\Http\Requests\Slider\SliderUpdateRequest;
use App\Models\Slider;

interface SliderInterface
{
    public function index(SliderIndexRequest $request);
    public function changeStatus(SliderChangeStatusRequest $request);
    public function store(SliderCreateRequest $request);
    public function show(Slider $slider);
    public function edit(Slider $slider);
    public function update(SliderUpdateRequest $request, Slider $slider);
    public function destroy(SliderDestroyRequest $request);
    public function massDestroy(SliderMassDestroyRequest $request);
    public function reorder(array $data);
    public function trash(SliderTrashRequest $request);
    public function restore(SliderRestoreRequest $request);
    public function remove(SliderRemoveRequest $request);
    public function massRemove(SliderMassRemoveRequest $request);
}
