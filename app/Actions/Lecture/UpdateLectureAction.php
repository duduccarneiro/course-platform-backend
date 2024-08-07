<?php

namespace App\Actions\Lecture;

use App\Models\Lecture;
use App\Data\Lecture\CourseLectureData;

class UpdateLectureAction
{
    public static function run(CourseLectureData $data, Lecture $lecture)
    {
        return tap($lecture)->update([
            'title' => $data->title
        ]);
    }
}
