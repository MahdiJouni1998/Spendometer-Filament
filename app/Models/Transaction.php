<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Scopes\UserScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
	use SoftDeletes;
	protected $table = 'transactions';

	protected $casts = [
		'date' => 'datetime',
		'amount' => 'float',
        'balance_id' => 'int',
		'iou_id' => 'int',
		'category_id' => 'int'
	];

    protected $appends = [
        'currency'
    ];

	protected $fillable = [
		'name',
		'date',
		'type',
		'amount',
		'description',
        'balance_id',
		'iou_id',
		'category_id'
	];

    public function getCurrencyAttribute()
    {
        return $this->balance()->first()->currency;
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }

	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	public function iou(): BelongsTo
	{
		return $this->belongsTo(Iou::class);
	}

    public function balance(): BelongsTo
    {
        return $this->belongsTo(Balance::class);
    }

    public function cashBacks(): HasMany
    {
        return $this->hasMany(CashBack::class);
    }
}
