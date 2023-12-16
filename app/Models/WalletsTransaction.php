<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Scopes\UserScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletsTransaction extends Model
{
	use SoftDeletes;
	protected $table = 'wallets_transactions';

	protected $casts = [
		'date' => 'datetime',
		'balance_from' => 'int',
		'amount_from' => 'float',
		'balance_to' => 'int',
		'amount_to' => 'float',
		'user_id' => 'int'
	];

    protected $appends = [
        'currency_from',
        'currency_to',
    ];

	protected $fillable = [
		'name',
		'date',
		'type',
		'balance_from',
		'amount_from',
		'balance_to',
		'amount_to',
		'description',
		'user_id'
	];

    public function getCurrencyFromAttribute()
    {
        return $this->balanceFrom()->first()->currency;
    }

    public function getCurrencyToAttribute()
    {
        return $this->balanceTo()->first()->currency;
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

    public function balanceFrom(): BelongsTo
    {
        return $this->belongsTo(Balance::class, 'balance_from');
    }

//    public function walletFrom(): BelongsTo
//    {
//        return $this->balanceFrom()->get()->wallet();
//    }

    public function balanceTo(): BelongsTo
    {
        return $this->belongsTo(Balance::class, 'balance_to');
    }

//    public function walletTo(): BelongsTo
//    {
//        return $this->balanceTo()->get()->wallet();
//    }
}
