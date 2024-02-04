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
		'iou_id' => 'int',
		'category_id' => 'int'
	];

    protected $appends = [
        'currency',
        'amount'
    ];

	protected $fillable = [
		'name',
		'date',
		'type',
		'description',
		'iou_id',
		'category_id',
	];

    public function getCurrencyAttribute()
    {
        return null;
    }

    public function getAmountAttribute()
    {
        $amount = 0;
        $payments = $this->payments()->get();
        foreach ($payments as $payment) {
            $currency = $payment->currency;
            $amount += $payment->amount;
        }
        return $amount;
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

    public function cashBacks(): HasMany
    {
        return $this->hasMany(CashBack::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(TransactionPayment::class);
    }
}
