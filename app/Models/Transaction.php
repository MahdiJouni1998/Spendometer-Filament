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

class Transaction extends Model
{
	use SoftDeletes;
	protected $table = 'transactions';

	protected $casts = [
		'date' => 'datetime',
		'amount' => 'float',
		'wallet_id' => 'int',
		'iou_id' => 'int',
		'category_id' => 'int'
	];

	protected $fillable = [
		'name',
		'date',
		'type',
		'amount',
		'currency',
		'description',
		'wallet_id',
		'iou_id',
		'category_id'
	];

	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}

	public function iou(): BelongsTo
	{
		return $this->belongsTo(Iou::class);
	}

	public function wallet(): BelongsTo
	{
		return $this->belongsTo(Wallet::class);
	}

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }
}
