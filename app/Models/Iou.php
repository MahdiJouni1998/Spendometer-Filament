<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Iou
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Transaction[] $transactions
 *
 * @package App\Models
 */
class Iou extends Model
{
	use SoftDeletes;
	protected $table = 'ious';

	protected $fillable = [
		'name'
	];

	public function transactions(): HasMany
	{
		return $this->hasMany(Transaction::class);
	}
}
