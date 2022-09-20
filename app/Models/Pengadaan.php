<?php

namespace App\Models;

use App\Models\Ticket;
use App\Models\Technician;
use Laravel\Scout\Searchable;
use App\Models\PengadaanStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengadaan extends Model
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
     * The table associated with the model.
     * 
     * @var  string
     */
    protected $table = 'pengadaan';

    public function pengadaan_status()
    {
        return $this->belongsTo(PengadaanStatus::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function toSearchableArray()
    {
        return [
            'technician_id' => $this->technician_id,
            'ticket_id' => $this->ticket_id,
            'merk' => $this->merk,
            'jenis' => $this->jenis,
            'quantity' => $this->quantity,
        ];
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
