<?php
namespace App\Contracts;

use App\Http\Requests\Customer\CustomerChangeStatusRequest;
use App\Http\Requests\Customer\CustomerCreateRequest;
use App\Http\Requests\Customer\CustomerDestroyRequest;
use App\Http\Requests\Customer\CustomerIndexRequest;
use App\Http\Requests\Customer\CustomerMassDestroyRequest;
use App\Http\Requests\Customer\CustomerMassRemoveRequest;
use App\Http\Requests\Customer\CustomerRemoveRequest;
use App\Http\Requests\Customer\CustomerRestoreRequest;
use App\Http\Requests\Customer\CustomerTrashRequest;
use App\Http\Requests\Customer\CustomerUpdateRequest;
use App\Models\Customer;

interface CustomerInterface
{
    public function index(CustomerIndexRequest $request);
    public function getSeoFirst(Customer $customer);
    public function changeStatus(CustomerChangeStatusRequest $request);
    public function store(CustomerCreateRequest $request);
    public function show(Customer $customer);
    public function edit(Customer $customer);
    public function update(CustomerUpdateRequest $request, Customer $customer);
    public function destroy(CustomerDestroyRequest $request);
    public function massDestroy(CustomerMassDestroyRequest $request);
    public function trash(CustomerTrashRequest $request);
    public function restore(CustomerRestoreRequest $request);
    public function remove(CustomerRemoveRequest $request);
    public function massRemove(CustomerMassRemoveRequest $request);
}
