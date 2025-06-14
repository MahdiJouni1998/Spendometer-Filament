<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Scopes\UserScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Iou extends Model
{
	use SoftDeletes;
	protected $table = 'ious';

	protected $fillable = [
		'name'
	];

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }

	public function transactions(): HasMany
	{
		return $this->hasMany(Transaction::class);
	}

    public function recurringPayments(): HasMany
    {
        return $this->hasMany(RecurringPayment::class);
    }
}
