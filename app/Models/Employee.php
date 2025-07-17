<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'phone',
        'image',
        'position',
        'division_id'
    ];

    protected $with = ['division'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
