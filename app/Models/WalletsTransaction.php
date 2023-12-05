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
		'wallet_from' => 'int',
		'amount_from' => 'float',
		'wallet_to' => 'int',
		'amount_to' => 'float',
		'user_id' => 'int'
	];

	protected $fillable = [
		'name',
		'date',
		'type',
		'wallet_from',
		'amount_from',
		'currency_from',
		'wallet_to',
		'amount_to',
		'currency_to',
		'description',
		'user_id'
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

    public function walletTo(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_to');
    }

    public function walletFrom(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_from');
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }
}
