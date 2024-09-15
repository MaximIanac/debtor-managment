<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $total_debt
 * @property int $is_paid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\DebtorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Debtor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Debtor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Debtor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Debtor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Debtor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Debtor whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Debtor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Debtor whereTotalDebt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Debtor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Debtor whereUserId($value)
 * @mixin \Eloquent
 */
class Debtor extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'total_debt', 'is_paid'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'debtor_id');
    }
}
