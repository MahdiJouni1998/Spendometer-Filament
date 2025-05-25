<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecurringPaymentsLog extends Model
{
	protected $table = 'recurring_payments_log';

	protected $casts = [
        'recurring_payment_id' => 'int',
        'transaction_id' => 'int',
		'payment_date' => 'datetime',
	];

	protected $fillable = [
		'recurring_payment_id',
        'transaction_id',
		'payment_date',
		'amount',
	];

    protected static function booted(): void
    {
        static::created(function (RecurringPaymentsLog $recurringPaymentsLog) {
            $recurringPaymentsLog->amount = $recurringPaymentsLog->transaction()->first()->amount;
            $recurringPaymentsLog->save();
        });
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

	public function recurring_payment(): BelongsTo
	{
		return $this->belongsTo(RecurringPayment::class);
	}
}
