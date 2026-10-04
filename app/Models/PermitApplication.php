<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PermitApplication extends Model
{
    protected $fillable = [
        'nomor_pendaftaran', 'user_id', 'permit_type_id', 
        'status', 'catatan_revisi', 'file_surat_hasil'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function permitType(): BelongsTo
    {
        return $this->belongsTo(PermitType::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(PermitDocument::class);
    }
}