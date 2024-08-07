<?php

namespace App\Http\Controllers\Instructor;

use App\Actions\Lecture\DeleteLectureAction;
use App\Actions\Lecture\ReorderCourseLecturesAction;
use App\Actions\Lecture\StoreLectureAction;
use App\Actions\Lecture\UpdateLectureAction;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Lecture\CourseLectureData;
use App\Http\Resources\LectureResource;
use App\Http\Resources\SectionResource;
use App\Models\Lecture;
use App\Models\Section;
use Illuminate\Support\Facades\Gate;

class InstructorLectureController extends Controller
{

    public function store(CourseLectureData $data, Course $course, Section $section)
    {
        Gate::authorize('update', $course);

        $lecture = StoreLectureAction::run($data, $section);

        ReorderCourseLecturesAction::run($course);

        return LectureResource::make($lecture->fresh());
    }

    public function update(CourseLectureData $data, Course $course, Lecture $lecture)
    {
        Gate::authorize('update', $course);

        $lecture = UpdateLectureAction::run($data, $lecture);

        return LectureResource::make($lecture);
    }

    public function destroy(Course $course, Lecture $lecture)
    {
        Gate::authorize('update', $course);

        DeleteLectureAction::run($lecture);

        ReorderCourseLecturesAction::run($lecture->course);

        return SectionResource::collection($course->sections->load('lectures'));
    }
}
