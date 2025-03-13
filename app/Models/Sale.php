<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'client_id',
        'total',
        'tax',
        'discount',
        'payment_method',
        'is_invoiced',
        'sale_date',
        'status',
    ];

    protected $dates = [
        'sale_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'sale_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relación con el modelo Client
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    // Relación con el modelo User (vendedor)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con los detalles de la venta
    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}