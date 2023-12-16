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

class Balance extends Model
{
	use SoftDeletes;
	protected $table = 'balances';

	protected $casts = [
		'wallet_id' => 'int',
		'amount' => 'float',
		'user_id' => 'int'
	];

	protected $fillable = [
		'wallet_id',
        'name',
		'amount',
		'currency',
		'user_id'
	];

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function wallet(): BelongsTo
	{
		return $this->belongsTo(Wallet::class);
	}
}
