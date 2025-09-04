<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuotationChargeRequest;
use App\Models\QuotationCharge;
use Illuminate\Http\Request;

class QuotationChargeController extends Controller
{
    public function index()
    {

        $charges = QuotationCharge::orderBy('id','DESC')->get();

        return view('backend.quotation_charges.index', compact('charges'));
    }

    public function store(QuotationChargeRequest $request)
    {

        QuotationCharge::create($request->validated());

        return back()->with('success', 'Quotation Charge Added Successfully');

    }

    public function update(Request $request)
    {
        $request->validate([
            'charge_id' => 'required|exists:quotation_charges,id',
            'amount' => 'required|numeric',
        ]);

        $charge=QuotationCharge::find($request->charge_id);
        $charge->surcharge=$request->amount;
        $charge->save();
        return back()->with('success', 'Quotation Charge Updated Successfully');

    }

    public function activate(Request $request)
    {

        $request->validate([
            'charge_id' => 'required|exists:quotation_charges,id',
        ]);

        $charge = QuotationCharge::find($request->charge_id);
        if ($charge->is_active == 1) {
            $charge->is_active = 0;
        } else {
            $charge->is_active = 1;
        }
        $charge->save();
        return back()->with('success', 'Quotation Charge Activated Successfully');

    }
}
