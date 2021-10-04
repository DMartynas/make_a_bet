<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\BetSelection
 *
 * @property int $id
 * @property int $bet_id
 * @property int $selection_id
 * @property string $odds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BetSelection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BetSelection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BetSelection query()
 * @method static \Illuminate\Database\Eloquent\Builder|BetSelection whereBetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BetSelection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BetSelection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BetSelection whereOdds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BetSelection whereSelectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BetSelection whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Bet $bet
 */
class BetSelection extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['selection_id', 'odds', 'bet_id'];

     /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'odds' => 'double'
    ];

    /**
     * Get the bet that owns the BetSelection
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bet(): BelongsTo
    {
        return $this->belongsTo(Bet::class);
    }
}
