<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Notifications\WelcomeMail;

/**
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserArtifact[] $artifacts
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname'
    ];

    protected $with = ['artifacts'];

    protected static function booted(): void
    {
        static::created(function (User $user) {
            $user->notify((new WelcomeMail())->delay(now()->addSeconds(5)));
        });
    }

    public function routeNotificationForMail(): array|string 
    {          
        return $this->artifacts()->allEmails()->pluck('artifact_value')->toArray();    
    }

    public function artifacts(): HasMany
    {
        return $this->hasMany(UserArtifact::class)
            ->orderByDesc('created_at');
    }
}
