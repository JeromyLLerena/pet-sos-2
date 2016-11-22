<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	protected $table = 'users';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function posts()
	{
		return $this->hasMany('App\Models\Post', 'user_id', 'id');
	}

	public function pets()
	{
		return $this->hasMany('App\Models\Pet', 'user_id');
	}

	public function district()
	{
		return $this->belongsTo('App\Models\District', 'district_id');
	}

	public function user_type(){
		return $this->belongsTo('App\Models\UserType', 'user_type_id');
	}
}
