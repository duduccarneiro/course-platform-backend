<?php

namespace App\Actions\Lecture;

use App\Models\Lecture;

class DeleteLectureAction
{
    public static function run(Lecture $lecture)
    {
        $lecture->delete();
    }
}
