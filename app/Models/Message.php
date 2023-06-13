<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $content
 * @property array $options
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class Message extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
        'group_id',
        'user_id',
        'options',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'content' => 'encrypted',
        'options' => 'array',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * Interact with the message's content.
     */
    protected function contents(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->convertContent(),
        );
    }

    /**
     * Interact with the message's content.
     */
    protected function readableCreatedAt(): Attribute
    {
        return Attribute::make(
            get: fn () => Helper::convertMessageSentDatetime($this->created_at),
        );
    }

    /**
     * Get the group that owns the message.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the user that owns the message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function convertContent()
    {
        if ($this->deleted_at) {
            $name = $this->user_id == auth()->id() ? 'You' : $this->user->name;
            return "<span class='text-muted fst-italic'>{$name} removed a message</span>";
        }

        return preg_replace('!(http|ftp|scp)(s)?:\/\/[\S\w]+!', "<a href=\"\\0\" target='_blank'>\\0</a>", $this->content);
    }
}
