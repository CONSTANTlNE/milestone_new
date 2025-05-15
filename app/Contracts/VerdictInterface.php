<?php
namespace App\Contracts;

use App\Http\Requests\ChangeStatusRequest;
use App\Http\Requests\RewriteRequest;
use App\Http\Requests\Verdict\VerdictCreateRequest;
use App\Http\Requests\MassDestroyRequest;
use App\Http\Requests\MassRemoveRequest;
use App\Http\Requests\Verdict\VerdictUpdateRequest;
use App\Http\Requests\RemoveRequest;
use App\Models\Verdict;

interface VerdictInterface
{
    public function getVerdicts();
    public function rewriteVerdict(RewriteRequest $request);
    public function getVerdictsParent();
    public function getSeoFirst(Verdict $verdict);
    public function changeStatus(ChangeStatusRequest $request);
    public function store(VerdictCreateRequest $request);
    public function show(Verdict $verdict);
    public function edit(Verdict $verdict);
    public function update(VerdictUpdateRequest $request, Verdict $verdict);
    public function destroy(Verdict $verdict);
    public function massDestroy(MassDestroyRequest $request);
    public function restore(Verdict $verdict);
    public function remove(RemoveRequest $verdict);
    public function massRemove(MassRemoveRequest $request);
}
