<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $profile_photo_url
 * @property integer $status
 * @property array $options
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection $groups
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * Statuses.
     */
    public const STATUS_ACTIVE = 1;
    public const STATUS_AWAY = 2;
    public const STATUS_DO_NOT_DISTURB = 3;
    public const STATUS_INVISIBLE = 4;

    /**
     * List of statuses.
     *
     * @var array
     */
    public static array $statuses = [
        self::STATUS_ACTIVE,
        self::STATUS_AWAY,
        self::STATUS_DO_NOT_DISTURB,
        self::STATUS_INVISIBLE,
    ];

    /**
     * Default options
     *
     * @var array
     */
    public static array $defaultOptions = [
        'bg-color' => 1,
        'bg-image' => 1,
        'group-favorites' => [],
    ];

    /**
     * Themes
     *
     * @var array
     */
    public static array $themes = [
        'color-classes' => [
            1 => ['class' => 'bg-primary-custom', 'color' => '78, 172, 109'],
            2 => ['class' => 'bg-info', 'color' => '80, 165, 241'],
            3 => ['class' => 'bg-purple', 'color' => '97, 83, 204'],
            4 => ['class' => 'bg-pink', 'color' => '232, 62, 140'],
            5 => ['class' => 'bg-danger', 'color' => '239, 71, 111'],
            6 => ['class' => 'bg-secondary', 'color' => '121, 124, 140'],
            7 => ['class' => 'bg-light', 'color' => ''],
        ],
        'images' => [
            1 => 'assets/images/bg-pattern/pattern-01.png',
            2 => 'assets/images/bg-pattern/pattern-02.png',
            3 => 'assets/images/bg-pattern/pattern-03.png',
            4 => 'assets/images/bg-pattern/pattern-04.png',
            5 => 'assets/images/bg-pattern/pattern-05.png',
            6 => 'assets/images/bg-pattern/pattern-06.png',
            7 => 'assets/images/bg-pattern/pattern-07.png',
            8 => 'assets/images/bg-pattern/pattern-08.png',
            9 => 'assets/images/bg-pattern/pattern-09.png',
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'options',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    /**
     * Interact with the user's options.
     */
    protected function options(): Attribute
    {
        return Attribute::make(
            get: fn () => array_merge(self::$defaultOptions, $this->getArrayAttributeByKey('options')),
        );
    }

    /**
     * The groups that belong to the user.
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    /**
     * Get the messages for the user.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the number of unread messages.
     */
    public function countUnread(Group $group): int
    {
        return 0;
    }

    /**
     * Get background color by user status.
     */
    public function getBGColor()
    {
        return [
            self::STATUS_ACTIVE => 'bg-success',
            self::STATUS_AWAY => 'bg-warning',
            self::STATUS_DO_NOT_DISTURB => 'bg-danger',
            self::STATUS_INVISIBLE => 'bg-light',
        ][$this->status];
    }
}
