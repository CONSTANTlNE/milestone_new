<?php
namespace App\Contracts;

use App\Http\Requests\Portfolio\PortfolioChangeStatusRequest;
use App\Http\Requests\Portfolio\PortfolioCreateRequest;
use App\Http\Requests\Portfolio\PortfolioDestroyRequest;
use App\Http\Requests\Portfolio\PortfolioIndexRequest;
use App\Http\Requests\Portfolio\PortfolioMassDestroyRequest;
use App\Http\Requests\Portfolio\PortfolioMassRemoveRequest;
use App\Http\Requests\Portfolio\PortfolioRemoveRequest;
use App\Http\Requests\Portfolio\PortfolioRestoreRequest;
use App\Http\Requests\Portfolio\PortfolioTrashRequest;
use App\Http\Requests\Portfolio\PortfolioUpdateRequest;
use App\Models\Portfolio;

interface PortfolioInterface
{
    public function index(PortfolioIndexRequest $request);
    public function getSeoFirst(Portfolio $portfolio);
    public function changeStatus(PortfolioChangeStatusRequest $request);
    public function store(PortfolioCreateRequest $request);
    public function show(Portfolio $portfolio);
    public function edit(Portfolio $portfolio);
    public function update(PortfolioUpdateRequest $request, Portfolio $portfolio);
    public function destroy(PortfolioDestroyRequest $request);
    public function massDestroy(PortfolioMassDestroyRequest $request);
    public function trash(PortfolioTrashRequest $request);
    public function restore(PortfolioRestoreRequest $request);
    public function remove(PortfolioRemoveRequest $request);
    public function massRemove(PortfolioMassRemoveRequest $request);
}
