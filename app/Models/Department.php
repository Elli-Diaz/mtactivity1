<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $primaryKey = 'department_id';
    public $incrementing = false;
    protected $keyType = 'int';

    public function Company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
}
