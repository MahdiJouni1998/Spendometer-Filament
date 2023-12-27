<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashBack extends Model
{
	use SoftDeletes;
	protected $table = 'cash_backs';

	protected $casts = [
		'transaction_id' => 'int',
		'balance_id' => 'int',
		'amount' => 'float'
	];

	protected $fillable = [
		'transaction_id',
		'balance_id',
		'amount'
	];

	public function balance(): BelongsTo
	{
		return $this->belongsTo(Balance::class);
	}

	public function transaction(): BelongsTo
	{
		return $this->belongsTo(Transaction::class);
	}
}
