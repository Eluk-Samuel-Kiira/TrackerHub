<?php

namespace App\Models;

use App\Http\Controllers\CurrencyController;
use Illuminate\Database\Eloquent\Model;

class ProjectInvoice extends Model
{
    protected $fillable = [
        'project_id',
        'client_id',
        'amount',
        'currency_id',
        'isPaid',
        'reference_number',
        'createdBy',
        'paidBy',
        'isActive',
    ];

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }

    public function client(){
        return $this->belongsTo(Client::class,'client_id');
    }

    public function currency(){
        return $this->belongsTo(Currency::class,'currency_id');
    }

    public function paidBy(){
        return $this->belongsTo(User::class,'paidBy');
    }

    public function createdBy(){
        return $this->belongsTo(User::class,'createdBy');
    }
}
