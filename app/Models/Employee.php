<?php

namespace App\Models;

use App\Models\User;
use App\Models\Gender;
use App\Models\Ticket;
use App\Models\Position;
use App\Models\SubDepartment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Employee extends Model
{
    use HasFactory, Searchable;

    protected $guarded = [
        'id',
    ];

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function makeAllSearchableUsing($query)
    {
        return $query->with(['gender', 'position', 'sub_department', 'ticket', 'user']);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function sub_department()
    {
        return $this->belongsTo(SubDepartment::class);
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }

    public function toSearchableArray()
    {
        return [
            'department' => $this->sub_department->department->department,
            'name' => $this->user->name,
            'nip' => $this->user->nip,
            'position' => $this->position->position,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
