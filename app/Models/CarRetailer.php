<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarRetailer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'legal_business_name',
        'dba',
        'business_type',
        'platform_type',
        'years_operation',
        'website_url',
        'contact_name',
        'contact_title',
        'contact_phone',
        'contact_email',
        'fulfillment_address',
        'multiple_warehouses',
        'shipping_nodes',
        'inventory_api_access',
        'api_url_docs',
        'vehicle_list',
        'cars_shipped',
        'vehicle_types',
        'transport_type',
        'preferred_delivery',
        'unattended_pickup',
        'billing_contact',
        'billing_email',
        'payment_method',
        'vendor_platforms',
        'ein_tax_id',
        'w9_upload',
        'insurance_certificate',
        'nda_required',
        'trade_references',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'platform_type' => 'array',
        'vehicle_types' => 'array',
        'years_operation' => 'integer',
        'cars_shipped' => 'integer',
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

    public function getFormattedPlatformTypeAttribute()
    {
        if (is_array($this->platform_type)) {
            return implode(', ', array_map('ucfirst', $this->platform_type));
        }
        return $this->platform_type;
    }

    public function getFormattedVehicleTypesAttribute()
    {
        if (is_array($this->vehicle_types)) {
            return implode(', ', array_map('ucfirst', $this->vehicle_types));
        }
        return $this->vehicle_types;
    }

    public function getFormattedPreferredDeliveryAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->preferred_delivery));
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
