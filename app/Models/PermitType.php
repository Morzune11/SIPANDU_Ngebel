<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PermitType extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_izin',
        'persyaratan',
        'estimasi_hari',
        'is_active',
    ];
}
