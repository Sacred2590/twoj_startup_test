<?php

namespace App\Models;

use App\Enums\UserArtifactsEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserArtifact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'artifact_name',
        'artifact_value',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected  $casts = [
        'artifact_name' => UserArtifactsEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAllEmails($query)
    {
        return $query->where('artifact_name', UserArtifactsEnum::EMAIL)
            ->orderByDesc('created_at');
    }

}
