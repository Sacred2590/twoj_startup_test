<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\UserCreatedEvent;
use App\Events\UserDeletedEvent;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Attributes\UseResource;

/**
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserArtifact[] $artifacts
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
#[UseResource(UserResource::class)]
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $dispatchesEvents = [
        'created' => UserCreatedEvent::class,
        'deleted' => UserDeletedEvent::class,
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname'
    ];

    /**
     * @var list<string, class-string<\BackedEnum>>
     */
    protected $with = ['artifacts'];

    /**
      *
      * @return array<int, string>
     */
    public function routeNotificationForMail(): array|string 
    {         
        return $this->artifacts()->allEmails()->pluck('artifact_value')->toArray();    
    }

    /**
     * @return HasMany<UserArtifact>
     */
    public function artifacts(): HasMany
    {
        return $this->hasMany(UserArtifact::class)
            ->orderByDesc('created_at');
    }
}
