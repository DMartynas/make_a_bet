<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bet
 *
 * @property int $id
 * @property string $stake_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Bet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bet whereStakeAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bet whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['stake_amount'];
}
