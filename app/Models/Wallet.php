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
 * Class Wallet
 * 
 * @property int $id
 * @property string $name
 * @property float $balance_usd
 * @property int $balance_lbp
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Transaction[] $transactions
 *
 * @package App\Models
 */
class Wallet extends Model
{
	use SoftDeletes;
	protected $table = 'wallets';

	protected $casts = [
		'balance_usd' => 'float',
		'balance_lbp' => 'int'
	];

	protected $fillable = [
		'name',
		'balance_usd',
		'balance_lbp'
	];

	public function transactions(): HasMany
	{
		return $this->hasMany(Transaction::class);
	}
}
