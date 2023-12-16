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

class Currency extends Model
{
	use SoftDeletes;
	protected $table = 'currencies';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'name',
		'symbol'
	];

    protected static function booted(): void
    {
        static::addGlobalScope(new UserScope);
    }

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
