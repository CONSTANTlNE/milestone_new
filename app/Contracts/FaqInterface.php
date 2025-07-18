<?php
namespace App\Contracts;

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
use App\Models\Faq;

interface FaqInterface
{
    public function index(FaqIndexRequest $request);
    public function changeStatus(FaqChangeStatusRequest $request);
    public function store(FaqCreateRequest $request);
    public function show(Faq $faq);
    public function edit(Faq $faq);
    public function update(FaqUpdateRequest $request, Faq $faq);
    public function destroy(FaqDestroyRequest $request);
    public function massDestroy(FaqMassDestroyRequest $request);
    public function trash(FaqTrashRequest $request);
    public function restore(FaqRestoreRequest $request);
    public function remove(FaqRemoveRequest $request);
    public function massRemove(FaqMassRemoveRequest $request);
}
