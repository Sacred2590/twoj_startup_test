<?php

namespace App\Models;

use App\Enums\UserArtifactsEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property UserArtifactsEnum $artifact_name
 * @property string $artifact_value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read User $user   
 */
class UserArtifact extends Model
{
    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'artifact_name',
        'artifact_value',
    ];

    /**
     * @var list<string>
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var list<string, class-string<\BackedEnum>>
     */
    protected  $casts = [
        'artifact_name' => UserArtifactsEnum::class,
    ];

    /**
     * @return BelongsTo<User, UserArtifact>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAllEmails($query)
    {
        return $query->where('artifact_name', UserArtifactsEnum::EMAIL)
            ->orderByDesc('created_at');
    }

}
