<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarrierDispatcher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'mc_number',
        'dot_number',
        'cars_under_management',
        'website_url',
        'presentation_file',
        'vehicle_list_file',
        'legal_business_name',
        'dba',
        'business_type',
        'years_operation',
        'contact_name',
        'contact_title',
        'contact_phone',
        'contact_email',
        'main_address',
        'multiple_locations',
        'additional_addresses',
        'billing_contact',
        'billing_email',
        'payment_method',
        'nda_required',
        'w9_upload',
        'insurance_certificate',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'payment_method' => 'array',
        'cars_under_management' => 'integer',
        'years_operation' => 'integer',
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
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'approved' => '<span class="badge bg-success">Approved</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending Review',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            default => 'Unknown',
        };
    }

    public function getPaymentMethodTextAttribute()
    {
        if (!$this->payment_method) return 'Not specified';
        
        return implode(', ', array_map(function($method) {
            return match($method) {
                'ach' => 'ACH',
                'credit_card' => 'Credit Card',
                'check' => 'Check',
                'other' => 'Other',
                default => ucfirst($method),
            };
        }, $this->payment_method));
    }

    // Mutators
    public function setMcNumberAttribute($value)
    {
        $this->attributes['mc_number'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setDotNumberAttribute($value)
    {
        $this->attributes['dot_number'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setContactPhoneAttribute($value)
    {
        $this->attributes['contact_phone'] = preg_replace('/[^0-9+\-\(\)\s]/', '', $value);
    }

    // Scopes for filtering
    public function scopeFilter($query, $request)
    {
        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('legal_business_name', 'like', "%{$request->search}%")
                  ->orWhere('contact_name', 'like', "%{$request->search}%")
                  ->orWhere('contact_email', 'like', "%{$request->search}%")
                  ->orWhere('mc_number', 'like', "%{$request->search}%")
                  ->orWhere('dot_number', 'like', "%{$request->search}%");
            });
        }

        return $query;
    }
}
