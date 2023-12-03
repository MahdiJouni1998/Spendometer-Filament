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

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }
}
