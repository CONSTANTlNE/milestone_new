<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorporateGovernmentFleet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'legal_organization_name',
        'dba',
        'business_type',
        'department',
        'years_operation',
        'website_url',
        'contact_name',
        'contact_title',
        'contact_phone',
        'contact_email',
        'fulfillment_address',
        'fleet_locations',
        'vehicle_release_contact',
        'fleet_management_software',
        'usage_type',
        'vehicle_condition',
        'vehicles_per_month',
        'transport_type',
        'transport_scope',
        'security_requirements',
        'pickup_protocols',
        'special_handling',
        'billing_contact',
        'billing_email',
        'payment_method',
        'vendor_portal_invoicing',
        'payment_platform',
        'government_corporate_id',
        'w9_upload',
        'insurance_certificate',
        'purchase_order_format',
        'references_contractors',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'usage_type' => 'array',
        'years_operation' => 'integer',
        'fleet_locations' => 'integer',
        'vehicles_per_month' => 'integer',
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

    public function getFormattedUsageTypeAttribute()
    {
        if (is_array($this->usage_type)) {
            return implode(', ', array_map('ucfirst', $this->usage_type));
        }
        return $this->usage_type;
    }

    public function getFormattedVehicleConditionAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->vehicle_condition));
    }

    public function getFormattedTransportScopeAttribute()
    {
        return ucfirst($this->transport_scope);
    }
}
