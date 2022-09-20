<?php

namespace App\Models;

use App\Models\User;
use App\Models\Gender;
use App\Models\Ticket;
use App\Models\Position;
use App\Models\SubDepartment;
use App\Models\TechnicianStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Technician extends Model
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

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function makeAllSearchableUsing($query)
    {
        return $query->with(['gender', 'position', 'sub_department', 'technician_status', 'user']);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function sub_department()
    {
        return $this->belongsTo(SubDepartment::class);
    }

    public function pengadaan()
    {
        return $this->hasMany(Pengadaan::class);
    }

    public function technician_status()
    {
        return $this->belongsTo(TechnicianStatus::class);
    }

    public function toSearchableArray()
    {
        return [
            'department' => $this->sub_department->department->department,
            'nip' => $this->user->nip,
            'position' => $this->position->position,
            'status' => $this->technician_status->status,
            'user' => $this->user->name,
        ];
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
