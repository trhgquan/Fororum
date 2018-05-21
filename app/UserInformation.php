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
	 * @return array boolean banned, admin, confirmed
	 */
	public static function userPermissions($id)
	{
		return [
			'banned' => self::userBanned($id),
			'admin' => self::userAdmin($id),
			'confirmed' => self::userConfirmed($id)
		];
	}

	/**
	 * method userBrandLevels
	 * @param int $id
	 * @return string brand level của user
	 */
	public static function userBrandLevels($id)
	{
		$permissions = self::userPermissions($id);
		switch ($permissions) {
			case $permissions['admin']:
				return 'tài khoản hệ thống';
				break;
			case $permissions['banned']:
				return 'tài khoản đã bị khóa';
				break;
			case $permissions['confirmed']:
				return 'tài khoản chính thức';
				break;
			default:
				return '';
				break;
		}
	}

	/**
	 * protected method userBanned
	 * @param int $id
	 * @return boolean true nếu user bị ban
	 */
	protected static function userBanned($id)
	{
		return (self::find($id)->permissions == 0) ? true : false;
	}

	/**
	 * protected method userAdmin
	 * @param int $id
	 * @return boolean true nếu user là admin
	 */
	protected static function userAdmin($id)
	{
		return (self::find($id)->permissions == 2) ? true : false;
	}

	/**
	 * protected method userConfirmed
	 * @param int $id
	 * @return boolean true nếu user đã xác nhận tài khoản
	 */
	protected static function userConfirmed($id)
	{
		return (self::find($id)->confirmed == 1) ? true : false;
	}
}
