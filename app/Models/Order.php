<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'total_amount',
        'payment_status',
        'payment_method',
        'transaction_id',
        'billing_first_name',
        'billing_last_name',
        'billing_email',
        'billing_phone',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_postal_code',
        'billing_country',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',
        'tracking_number',
        'shipped_at',
        'delivered_at',
        'notes',
        'admin_notes'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    // Automatically generate order number when creating
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = 'RUB-' . strtoupper(Str::random(8));
            }
        });
    }

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Get status badge color
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    // Get payment status badge color
    public function getPaymentStatusBadgeAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'refunded' => 'info',
            default => 'secondary'
        };
    }

    // Get full billing name
    public function getBillingFullNameAttribute()
    {
        return $this->billing_first_name . ' ' . $this->billing_last_name;
    }

    // Get full shipping name
    public function getShippingFullNameAttribute()
    {
        return $this->shipping_first_name . ' ' . $this->shipping_last_name;
    }

    // Get full billing address
    public function getBillingFullAddressAttribute()
    {
        return $this->billing_address . ', ' . $this->billing_city . ', ' . 
               $this->billing_state . ' ' . $this->billing_postal_code . ', ' . 
               $this->billing_country;
    }

    // Get full shipping address
    public function getShippingFullAddressAttribute()
    {
        return $this->shipping_address . ', ' . $this->shipping_city . ', ' . 
               $this->shipping_state . ' ' . $this->shipping_postal_code . ', ' . 
               $this->shipping_country;
    }

    // Scope for different statuses
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeShipped($query)
    {
        return $query->where('status', 'shipped');
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Check if order can be cancelled
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    // Check if order can be shipped
    public function canBeShipped()
    {
        return $this->status === 'processing' && $this->payment_status === 'paid';
    }
}
