<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficialCase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'status',
        'company_id',
        'suspension_date',
        'lifted_date',
        'days_suspended',
        'employer_id',
        'case_officer',
        'worker_id',
        'atnsia_no',
        'complaint_id',
        'complaint',
        'remarks',
    ];

    protected $with = ['company', 'employer', 'worker'];

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function employer()
    {
        return $this->hasOne(Employer::class, 'id', 'employer_id');
    }

    public function worker()
    {
        return $this->hasOne(Worker::class, 'id', 'worker_id');
    }
}
