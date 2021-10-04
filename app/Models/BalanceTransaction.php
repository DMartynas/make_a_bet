<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\BalanceTransaction
 *
 * @property int $id
 * @property int $player_id
 * @property string $amount
 * @property string $previous_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceTransaction wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceTransaction wherePreviousAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceTransaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BalanceTransaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['amount', 'previous_amount', 'player_id'];

     /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'double',
        'previous_amount' => 'double'
    ];

    /**
     * Get the player that owns the BalanceTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
