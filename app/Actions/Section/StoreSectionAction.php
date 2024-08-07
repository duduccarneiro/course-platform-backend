<?php

namespace App\Actions\Section;

use App\Data\Section\CourseSectionData;
use App\Models\Course;

class StoreSectionAction
{
    public static function run(CourseSectionData $data, Course $course)
    {
        $max_sort = $course->sections()->max('sort_order');

        return $course->sections()->create([
            'title' => $data->title,
            'sort_order' => $max_sort + 1
        ]);
    }
}
