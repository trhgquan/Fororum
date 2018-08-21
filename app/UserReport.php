<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    const max_display = 5; // pagination

    protected $table = 'users_reports';

    protected $fillable = ['id', 'user_id', 'participant_id', 'type', 'reason', 'reviewed'];

    /**
     * what users can report.
     *
     * @var array
     */
    protected static $reportable = ['profile', 'post'];

    /**
     * procedure review
     * this action will loop through the Database
     * looking for users reporting same account.
     *
     * @param int    $report_id
     * @param string $action
     *
     * @return null
     */
    public static function review($report_id, $action)
    {
        $report = self::report_information($report_id);

        $all_reports = self::where([
            ['participant_id', '=', $report->participant_id],
            ['type', '=', $report->type],
            ['reviewed', '=', 0],
        ])->get();

        foreach ($all_reports as $one_report) {
            $report = self::report_information($one_report->id);
            $report->reviewed = 1;
            $report->save();
        }
    }

    /**
     * method not_reviewed.
     *
     * @return array
     */
    public static function not_reviewed()
    {
        return [
            'total'   => self::where('reviewed', 0)->count(),
            'profile' => self::where([
                ['reviewed', '=', 0],
                ['type', '=', 'profile'],
            ])->count(),
            'post' => self::where([
                ['reviewed', '=', 0],
                ['type', '=', 'post'],
            ])->count(),
        ];
    }

    /**
     * [report_information description].
     *
     * @param int $report_id
     *
     * @return object
     */
    public static function report_information($report_id)
    {
        return self::find($report_id);
    }

    /**
     * method is_reported.
     *
     * @param int    $user_id
     * @param int    $participant_id
     * @param string $type
     *
     * @return bool
     */
    public static function is_reported($user_id, $participant_id, $type)
    {
        return self::where([
            ['user_id', '=', $user_id],
            ['participant_id', '=', $participant_id],
            ['type', '=', $type],
            ['reviewed', '=', 0],
        ])->exists();
    }

    /**
     * method reportable.
     *
     * @param int    $user
     * @param int    $participant
     * @param string $type
     *
     * @return bool
     */
    public static function reportable($user, $participant, $type)
    {
        if (in_array($type, self::$reportable)) {
            if (self::is_profile($type)) {
                $participant_profile = User::username($participant);
                $participant_id = User::profile($participant_profile)->id;
                $permissions = UserInformation::userPermissions($participant_id);

                return ($participant_id !== $user && !$permissions['admin'] && !$permissions['banned']) ? true : false;
            }
            $creator = ForumPosts::post($participant)->user_id;

            return ($creator !== $user) ? true : false;
        }

        return false;
    }

    /**
     * method participant_title.
     *
     * @param int    $participant_id
     * @param string $type
     *
     * @return string
     */
    public static function participant_title($participant_id, $type)
    {
        if (!self::is_profile($type)) {
            return ForumPosts::postTitle($participant_id);
        }

        return User::username($participant_id);
    }

    /**
     * method getUsersOnly.
     *
     * @return object
     */
    public static function getUsersOnly()
    {
        return self::where([
            ['reviewed', '=', 0],
            ['type', '=', 'profile'],
        ])->orderBy('id', 'DESC')->paginate(self::max_display);
    }

    /**
     * private method is_profile.
     *
     * @param string $type
     *
     * @return bool
     */
    protected static function is_profile($type)
    {
        return ($type === 'profile') ? true : false;
    }
}
