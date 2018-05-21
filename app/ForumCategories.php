<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumCategories extends Model
{
	protected $table = 'forum_categories';

	protected $fillable = ['keyword', 'title', 'description'];

	protected $hidden = [];

	/**
	 * method ForumCategories
	 * @return object tất cả các category trong forum.
	 */
	public static function ForumCategories()
	{
		return self::get();
	}

	/**
	 * method CategoryExist
	 * @param $category
	 * @return boolean true nếu category tồn tại, false nếu category không tồn tại.
	 */
	public static function CategoryExist($category)
	{
		return self::where('keyword', $category)->orWhere('id', $category)->exists();
	}

	/**
	 * method Category
	 * @param $category
	 * @return object content của $category
	 */
	public static function Category ($category)
	{
		return self::where('keyword', $category)->orWhere('id', $category)->firstOrFail();
	}
}
