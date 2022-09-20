<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Technician;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gender extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }

    public function technician()
    {
        return $this->hasMany(Technician::class);
    }
}
