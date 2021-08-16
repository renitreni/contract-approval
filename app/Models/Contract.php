<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'custom_id',
        'type',
        'content',
    ];

    public function audit()
    {
        return $this->hasMany(ContractAudit::class, 'contract_id', 'id');
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public static function fetchPending()
    {
        return (new static)->query()
                           ->selectRaw('contracts.*, ca.status')
                           ->join('contract_audits as ca', 'ca.contract_id', '=', 'contracts.id')
                           ->where('ca.status', 'pending')
                           ->with(['creator']);
    }

    public static function fetchPendingCount()
    {
        return (new static)->query()
                           ->selectRaw('contracts.*, ca.status')
                           ->join('contract_audits as ca', 'ca.contract_id', '=', 'contracts.id')
                           ->where('ca.status', 'pending')
                           ->count();
    }

    public static function fetchApproved()
    {
        return (new static)->query()
                           ->selectRaw('contracts.*, ca.status')
                           ->join('contract_audits as ca', 'ca.contract_id', '=', 'contracts.id')
                           ->where('ca.status', 'approved')
                           ->with(['creator']);
    }
}
