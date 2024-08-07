<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Course;
use App\Enums\CourseLevel;
use Illuminate\Http\Request;
use App\Data\Course\StoreCourseData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Data\Course\UpdateCourseData;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CategoryResource;
use App\Actions\Course\StoreCourseAction;
use App\Actions\Course\UpdateCourseAction;
use App\Data\Course\UploadCourseImageData;
use App\Actions\Course\UploadCourseImageAction;
use App\Actions\Category\GetAllCategoriesAction;
use App\Actions\Course\UpdateCourseStatusAction;
use App\Actions\Course\GetInstructorCoursesAction;

class InstructorCourseController extends Controller
{
    public function index()
    {
        $courses = GetInstructorCoursesAction::run();

        return CourseResource::collection($courses );
    }

    public function store(StoreCourseData $data)
    {
        $course = StoreCourseAction::run($data);

        return CourseResource::make($course);
    }

    public function show(Course $course)
    {
        return CourseResource::make($course);
    }

    public function getBasicInfo(Course $course)
    {
        return response()->json([
            'course' => CourseResource::make($course->load('category')),
            'categories' => CategoryResource::collection(GetAllCategoriesAction::run()),
            'levels' => CourseLevel::getArray()
        ]);
    }

    public function updateBasicInfo(UpdateCourseData $data, Course $course)
    {
        Gate::authorize('update', $course);

        /**@var Course $course */
        $course = UpdateCourseAction::run($data, $course);
        return CourseResource::make($course->load('category'));
    }

    public function cover(UploadCourseImageData $data, Course $course)
    {
        Gate::authorize('update', $course);

        $course = UploadCourseImageAction::run($data, $course);

        return CourseResource::make($course);
    }

    public function updateStatus(Course $course)
    {
        Gate::authorize('update', $course);

        abort_unless($course->canBePublished(), 401, 'Course not ready for status change');

        UpdateCourseStatusAction::run($course);

        return CourseResource::make($course);
    }

    public function curriculum(Course $course)
    {

    }
}
