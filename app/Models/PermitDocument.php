<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermitDocument extends Model
{
   protected $fillable = ['permit_application_id', 'nama_dokumen', 'file_path'];
}
