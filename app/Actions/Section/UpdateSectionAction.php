<?php

namespace App\Actions\Section;

use App\Models\Course;
use App\Models\Section;
use App\Data\Section\CourseSectionData;

class UpdateSectionAction
{
    public static function run(CourseSectionData $data, Section $section)
    {
        return tap($section)->update([
            'title' => $data->title
        ]);
    }
}
