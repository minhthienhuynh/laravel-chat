<?php

namespace App\Models;

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
        $content = preg_replace('!(http|ftp|scp)(s)?:\/\/[\S\w]+!', "<a href=\"\\0\">\\0</a>", $this->content);

        if ($this->deleted_at) {
            $name = $this->user_id == auth()->id() ? 'You' : $this->user->name;
            $content = "<span class='text-muted fst-italic'>{$name} removed a message</span>";
        }

        return $content;
    }
}
