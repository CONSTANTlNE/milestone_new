<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutoDealer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'legal_business_name',
        'dba',
        'business_type',
        'years_operation',
        'website_url',
        'contact_name',
        'contact_title',
        'contact_phone',
        'contact_email',
        'main_address',
        'multiple_locations',
        'additional_addresses',
        'dealer_license',
        'federal_tax_id',
        'duns_number',
        'cars_per_month',
        'vehicle_types',
        'transport_preference',
        'delivery_type',
        'inventory_contact',
        'pickup_times',
        'delivery_days',
        'billing_contact',
        'billing_email',
        'payment_method',
        'vendor_platforms',
        'nda_required',
        'trade_reference',
        'w9_upload',
        'insurance_certificate',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'vehicle_types' => 'array',
        'years_operation' => 'integer',
        'cars_per_month' => 'integer',
    ];

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="badge badge-warning">Pending</span>',
            'approved' => '<span class="badge badge-success">Approved</span>',
            'rejected' => '<span class="badge badge-danger">Rejected</span>',
            default => '<span class="badge badge-secondary">Unknown</span>'
        };
    }

    public function getFormattedVehicleTypesAttribute()
    {
        if (is_array($this->vehicle_types)) {
            return implode(', ', array_map('ucfirst', $this->vehicle_types));
        }
        return $this->vehicle_types;
    }

    public function getFormattedTransportPreferenceAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->transport_preference));
    }

    public function getFormattedDeliveryTypeAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->delivery_type));
    }

    // Filter scope
    public function scopeFilter($query, $request)
    {
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('legal_business_name', 'like', '%' . $request->search . '%')
                  ->orWhere('contact_name', 'like', '%' . $request->search . '%')
                  ->orWhere('contact_email', 'like', '%' . $request->search . '%')
                  ->orWhere('contact_phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        return $query;
    }

    public function scopeFilterTrash($query, $request)
    {
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('legal_business_name', 'like', '%' . $request->search . '%')
                  ->orWhere('contact_name', 'like', '%' . $request->search . '%')
                  ->orWhere('contact_email', 'like', '%' . $request->search . '%');
            });
        }

        return $query;
    }
}
