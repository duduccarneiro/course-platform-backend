<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Data\Section\CourseSectionData;
use App\Http\Resources\SectionResource;
use App\Actions\Section\StoreSectionAction;
use App\Actions\Section\DeleteSectionAction;
use App\Actions\Section\UpdateSectionAction;
use App\Actions\Section\ReorderCourseSectionsAction;

class InstructorSectionController extends Controller
{

    public function store(CourseSectionData $data, Course $course)
    {
        Gate::authorize('update', $course);

        $section = StoreSectionAction::run($data, $course);

        return SectionResource::make($section);
    }

    public function update(CourseSectionData $data, Course $course, Section $section)
    {
        Gate::authorize('update', $course);

        $section = UpdateSectionAction::run($data, $section);

        return SectionResource::make($section);
    }

    public function destroy(Course $course, Section $section)
    {
        Gate::authorize('update', $course);

        DeleteSectionAction::run($section);

        ReorderCourseSectionsAction::run($course);

        return response()->json(null, 200);
    }
}
