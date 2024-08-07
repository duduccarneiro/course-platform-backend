<?php

namespace App\Actions\Course;

use App\Data\Course\StoreCourseData;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreCourseAction
{
    public static function run(StoreCourseData $data)
    {
        $course = Course::create([
            'user_id' => Auth::id(),
            'title' => $data->title,
            'subtitle' => $data->subtitle,
            'category_id' => Category::getId($data->category),
            'subcategory_id' => Category::getId($data->subcategory),
        ]);

        return $course;
    }
}
