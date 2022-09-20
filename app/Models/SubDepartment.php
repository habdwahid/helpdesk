<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Technician;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class SubDepartment extends Model
{
    use HasFactory, Searchable;

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

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }

    public function makeAllSearchableUsing($query)
    {
        return $query->with('department');
    }

    public function technician()
    {
        return $this->hasMany(Technician::class);
    }

    public function toSearchableArray()
    {
        return [
            'department_id' => $this->department_id,
            'sub_department' => $this->sub_department,
        ];
    }
}
