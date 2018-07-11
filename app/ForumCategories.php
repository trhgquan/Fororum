<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumCategories extends Model
{
	const max_display = 1;

	protected $table = 'forum_categories';

	protected $fillable = ['keyword', 'title', 'description'];

	protected $hidden = [];

	/**
	 * method ForumCategories
	 * @return object
	 */
	public static function ForumCategories()
	{
		return self::get();
	}

	/**
	 * method paginatedForumCategories
	 * @return object
	 */
	public static function paginatedForumCategories ()
	{
		return self::paginate(self::max_display);
	}

	/**
	 * method CategoryExist
	 * @param $category
	 * @return boolean
	 */
	public static function CategoryExist($category)
	{
		return self::where('keyword', $category)->orWhere('id', $category)->exists();
	}

	/**
	 * method Category
	 * @param $category
	 * @return object
	 */
	public static function Category ($category)
	{
		return self::where('keyword', $category)->orWhere('id', $category)->firstOrFail();
	}

	/**
	 * procedure updateCategory
	 * @param  int $credential
	 * @param  object $new_data
	 */
	public static function updateCategory ($credential, $new_data)
	{
		$category = self::find($credential);
		$category->title = $new_data->title;
		$category->keyword = $new_data->keyword;
		$category->description = $new_data->description;
		$category->save();
	}
}
