<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractAudit extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'contract_id',
        'status',
        'notes',
        'audited_by',
    ];
}
