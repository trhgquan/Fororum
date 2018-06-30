<?php

namespace App;

use App\User;
use App\ForumPosts;
use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    const max_display = 1; // pagination

    protected $table = 'users_reports';

    protected $fillable = ['id','user_id','participant_id','type','reason','reviewed'];

    /**
     * what users can report.
     * @var array
     */
    protected static $reportable = ['profile', 'post'];

    /**
     * method not_reviewed
     * @return int
     */
    public static function not_reviewed ()
    {
        return self::where('reviewed', 0)->count();
    }

    /**
     * [report_information description]
     * @param  int $report_id
     * @return object
     */
    public static function report_information ($report_id)
    {
        return self::find($report_id);
    }

    /**
     * method is_reported
     * @param  int  $user_id
     * @param  int  $participant_id
     * @param  string  $type
     * @return bool
     */
    public static function is_reported ($user_id, $participant_id, $type)
    {
        return self::where([
            ['user_id', '=', $user_id],
            ['participant_id', '=', $participant_id],
            ['type', '=', $type],
            ['reviewed', '=', 0]
        ])->exists();
    }

    /**
     * method reportable
     * @param  int $user
     * @param  int $participant
     * @param  string $type
     * @return bool
     */
    public static function reportable ($user, $participant, $type)
    {
        if (in_array($type, self::$reportable))
        {
            if (self::is_profile($type))
            {
                $creator = User::username($participant);
                return (User::profile($creator)->id !== $user) ? true : false;
            }
            $creator = ForumPosts::post($participant)->user_id;
            return ($creator !== $user) ? true : false;
        }
        return false;
    }

    /**
     * method participant_title
     * @param  int $participant_id
     * @param  string $type
     * @return string
     */
    public static function participant_title ($participant_id, $type)
    {
        if (!self::is_profile($type))
        {
            return ForumPosts::postTitle($participant_id);
        }
        return User::username($participant_id);
    }

    /**
     * method getAll
     * @return object
     */
    public static function getAll ()
    {
        return self::where('reviewed', 0)->simplePaginate(self::max_display);
    }

    /**
     * private method is_profile
     * @param  string  $type
     * @return bool
     */
    private static function is_profile ($type)
    {
        return ($type === 'profile') ? true : false;
    }
}
