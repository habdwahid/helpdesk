<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Technician;
use App\Models\TicketStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Ticket extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'category_id',
        'description',
        'ticket_status_id',
        'technician_id',
        'employee_id',
        'solved_at',
    ];

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->isoFormat('D MMMM Y');
    }

    public function getSolvedAtAttribute()
    {
        return Carbon::parse($this->attributes['solved_at'])->isoFormat('D MMMM Y');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->isoFormat('D MMMM Y');
    }

    public function pengadaan()
    {
        return $this->hasMany(Pengadaan::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'category' => $this->category->category,
            'description' => $this->description,
            'name' => $this->employee->user->name,
            'position' => $this->employee->position->position,
            'technician' => $this->technician->user->name,
            'status' => $this->ticket_status_id,
            'updated_at' => $this->updated_at,
        ];
    }

    public function ticket_status()
    {
        return $this->belongsTo(TicketStatus::class);
    }
}
