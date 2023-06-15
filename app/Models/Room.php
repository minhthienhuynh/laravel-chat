<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Jetstream\HasProfilePhoto;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $type
 * @property bool $muted
 * @property array $options
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection $users
 * @property Collection $other_users
 * @property Collection $messages
 */
class Room extends Model
{
    use HasFactory;
    use HasProfilePhoto;
    use SoftDeletes;

    /**
     * Types.
     */
    public const TYPE_USER = 1;
    public const TYPE_GROUP = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'muted',
        'options',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'options' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The users that belong to the group.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * The other users that belong to the group.
     */
    public function other_users(): BelongsToMany
    {
        return $this->users()->whereKeyNot(auth()->id());
    }

    /**
     * Get the messages for the group.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function isUserType(): bool
    {
        return $this->type == self::TYPE_USER;
    }

    public function isGroupType(): bool
    {
        return $this->type == self::TYPE_GROUP;
    }
}
