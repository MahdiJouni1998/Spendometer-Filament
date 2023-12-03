<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
	use SoftDeletes;
	protected $table = 'incomes';

	protected $casts = [
		'amount' => 'float',
		'date_received' => 'datetime',
		'wallet_id' => 'int',
		'income_source_id' => 'int'
	];

	protected $fillable = [
		'amount',
		'currency',
		'date_received',
		'wallet_id',
		'income_source_id'
	];

	public function income_source(): BelongsTo
	{
		return $this->belongsTo(IncomeSource::class);
	}

	public function wallet(): BelongsTo
	{
		return $this->belongsTo(Wallet::class);
	}
}
