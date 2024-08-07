<?php

namespace App\Actions\Course;

use App\Models\Course;

class UpdateCourseStatusAction
{
    public static function run(Course $course)
    {
        $course->update([
            'published_at' => $course->isPublished() ? null : now()
        ]);
    }
}
