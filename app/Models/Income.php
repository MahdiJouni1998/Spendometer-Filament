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

class Income extends Model
{
	use SoftDeletes;
	protected $table = 'incomes';

	protected $casts = [
		'amount' => 'float',
		'date_received' => 'datetime',
		'balance_id' => 'int',
		'income_source_id' => 'int'
	];

    protected $appends = [
        'currency'
    ];

	protected $fillable = [
		'amount',
		'date_received',
		'balance_id',
		'income_source_id'
	];

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }

	public function income_source(): BelongsTo
	{
		return $this->belongsTo(IncomeSource::class);
	}

//	public function wallet(): BelongsTo
//	{
//		return $this->belongsTo(Wallet::class);
//	}

    public function balance(): BelongsTo
    {
        return $this->belongsTo(Balance::class);
    }

    public function getCurrencyAttribute()
    {
        return $this->balance()->first()->currency;
    }
}
