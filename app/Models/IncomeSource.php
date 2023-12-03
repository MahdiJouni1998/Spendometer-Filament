<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Scopes\UserScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }
}
