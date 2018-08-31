<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumCategories extends Model
{
    const max_display = 5;

    protected $table = 'forum_categories';

    protected $fillable = ['keyword', 'title', 'description'];

    protected $hidden = [];

    /**
     * method ForumCategories.
     *
     * @return object
     */
    public static function ForumCategories()
    {
        return self::get();
    }

    /**
     * method paginatedForumCategories
     * for admin control.
     *
     * @return object
     */
    public static function paginatedForumCategories()
    {
        return self::paginate(self::max_display);
    }

    /**
     * method CategoryExist.
     *
     * @param string $category
     *
     * @return bool
     */
    public static function CategoryExist($category)
    {
        return self::where('keyword', $category)->orWhere('id', $category)->exists();
    }

    /**
     * method Category.
     *
     * @param string $category
     *
     * @return mixed
     */
    public static function Category($category)
    {
        return self::where('keyword', $category)->orWhere('id', $category)->firstOrFail();
    }

    /**
     * procedure updateCategory.
     *
     * @param int    $credential
     * @param object $new_data
     */
    public static function updateCategory($credential, $new_data)
    {
        $category = self::find($credential);
        if ($new_data->keyword !== $category->keyword && !self::CategoryExist($new_data->keyword)):
            $category->keyword = $new_data->keyword;
        endif;
        $category->title = $new_data->title;
        $category->description = $new_data->description;
        $category->save();
    }

    /**
     * method breadcrumb
     * for category.
     *
     * @param int $something_id
     *
     * @return array
     */
    public static function breadcrumbs($something_id)
    {
        return [
            [
                'id'    => (int) $something_id,
                'title' => self::Category($something_id)->title,
            ],
        ];
    }
}
