<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
	protected $table = 'users_information';

	protected $fillable = ['id', 'confirmed', 'permissions'];

	protected $hidden = [];

	/**
	 * method userPermissions
	 * @param int $id
	 * @return array
	 */
	public static function userPermissions($id)
	{
		return [
			'banned' => self::userBanned($id),
			'admin' => self::userAdmin($id),
			'mod'   => self::userMod($id),
			'confirmed' => self::userConfirmed($id)
		];
	}

	/**
	 * protected method userBanned
	 * @param int $id
	 * @return bool
	 */
	protected static function userBanned($id)
	{
		return (self::find($id)->permissions == 0) ? true : false;
	}

	/**
	 * protected method userAdmin
	 * @param int $id
	 * @return bool
	 */
	protected static function userAdmin($id)
	{
		return (self::find($id)->permissions == 2) ? true : false;
	}

	/**
	 * protected method userMod
	 * @param  int $id
	 * @return bool
	 */
	protected static function userMod($id)
	{
		return (self::find($id)->permissions == 3) ? true : false;
	}

	/**
	 * protected method userConfirmed
	 * @param int $id
	 * @return bool
	 */
	protected static function userConfirmed($id)
	{
		return (self::find($id)->confirmed == 1) ? true : false;
	}
}
