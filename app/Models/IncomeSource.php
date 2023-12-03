<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class IncomeSource
 * 
 * @property int $id
 * @property string $name
 * @property float|null $amount
 * @property string|null $currency
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class IncomeSource extends Model
{
	use SoftDeletes;
	protected $table = 'income_sources';

	protected $casts = [
		'amount' => 'float'
	];

	protected $fillable = [
		'name',
		'amount',
		'currency'
	];
}
