<?php

namespace App\Http\Controllers\Instructor;

use App\Actions\Lecture\UpdateLectureArticleAction;
use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Lecture\LectureArticleContentData;
use App\Http\Resources\LectureResource;
use Illuminate\Support\Facades\Gate;

class InstructorLectureContentController extends Controller
{

    public function update(LectureArticleContentData $data, Course $course, Lecture $lecture)
    {
        Gate::authorize('update', $course);
        $lecture = UpdateLectureArticleAction::run($data, $lecture);

        return LectureResource::make($lecture);
    }

    public function upload(Request $request, Lecture $lecture)
    {
        // video upload
    }
}
