<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleManufacturer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'legal_business_name',
        'dba',
        'business_type',
        'years_operation',
        'website_url',
        'us_office_location',
        'contact_name',
        'contact_title',
        'contact_phone',
        'contact_email',
        'primary_port_factory',
        'us_distribution_centers',
        'delivery_frequency',
        'monthly_volume',
        'vin_batching_format',
        'new_car_prep',
        'transport_type',
        'vehicle_types',
        'load_prep_protocols',
        'special_handling',
        'delivery_destinations',
        'compliance_procedures',
        'billing_contact',
        'billing_email',
        'payment_method',
        'vendor_management_system',
        'system_name',
        'w9_upload',
        'insurance_certificate',
        'business_registration',
        'trade_references',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'vehicle_types' => 'array',
        'payment_method' => 'array',
        'years_operation' => 'integer',
        'monthly_volume' => 'integer',
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

    public function getFormattedDeliveryFrequencyAttribute()
    {
        return ucfirst($this->delivery_frequency);
    }

    public function getFormattedBusinessTypeAttribute()
    {
        return strtoupper(str_replace('_', ' ', $this->business_type));
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
