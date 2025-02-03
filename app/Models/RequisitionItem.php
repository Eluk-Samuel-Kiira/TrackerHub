<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequisitionItem extends Model
{
    protected $fillable = [
        'requisition_id', 'title', 'category_id', 'uom_id', 'quantity', 'unit_cost', 'amount', 'receipt_no'
    ];

    public function requisition()
    {
        return $this->belongsTo(Requistion::class);
    }
}
