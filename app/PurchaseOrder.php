<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'required',
        'number',
        'document',
        'requisition',
        'iscovered',
        'order_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
