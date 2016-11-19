<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
	protected $table = 'pets';

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}
}
