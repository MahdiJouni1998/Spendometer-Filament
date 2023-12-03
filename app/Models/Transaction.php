<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Transaction
 * 
 * @property int $id
 * @property string $name
 * @property Carbon $date
 * @property string $type
 * @property float $amount
 * @property string $currency
 * @property string $description
 * @property int $wallet_id
 * @property int $iou_id
 * @property int $category_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Category $category
 * @property Iou $iou
 * @property Wallet $wallet
 *
 * @package App\Models
 */
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
}
