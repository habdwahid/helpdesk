<?php

namespace App\Models;

use App\Models\SubDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Department extends Model
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

    public function sub_department()
    {
        return $this->hasMany(SubDepartment::class);
    }

    public function toSearchableArray()
    {
        return [
            'department' => $this->department,
        ];
    }
}
