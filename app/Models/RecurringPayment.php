<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Scopes\UserScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecurringPayment extends Model
{
    use SoftDeletes;
	protected $table = 'recurring_payments';

	protected $casts = [
        'user_id' => 'int',
        'iou_id' => 'int',
		'recurring_amount' => 'float',
		'total_amount' => 'float',
		'cycle_count' => 'float',
        'start_date' => 'date',
        'end_date' => 'date',
	];

	protected $fillable = [
        'user_id',
        'iou_id',
		'name',
		'recurring_amount',
		'total_amount',
		'currency',
		'details',
		'cycle_type',
		'cycle_count',
        'start_date',
        'end_date',
        'status'
	];

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function recurringPaymentsLogs(): HasMany
	{
		return $this->hasMany(RecurringPaymentsLog::class);
	}

    public function iou(): BelongsTo
    {
        return $this->belongsTo(Iou::class);
    }
}
