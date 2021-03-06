<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'file', 'cancelation_id', 'rebilling_id'
    ];

    public function cancelation()
    {
        return $this->belongsTo(Cancelation::class);
    }

    public function rebilling()
    {
        return $this->belongsTo(Rebilling::class);
    }

    public function debolution()
    {
        return $this->belongsTo(Debolution::class);
    }
}
