<?php

namespace App\Http\Controllers\Instructor;

use App\Actions\Lecture\HandleFileUploadAction;
use App\Actions\Lecture\UpdateLectureArticleAction;
use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Data\Lecture\LectureArticleContentData;
use App\Http\Resources\LectureResource;
use Illuminate\Support\Facades\Gate;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

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
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        // check if file successfully uploaded
        if( !$receiver->isUploaded() ) {
            throw new UploadMissingFileException();
        }

        // receive the file from client
        $chunks = $receiver->receive();

        // check if the upload has finished
        if( $chunks->isFinished() ) {
            // save the file and return a response to the frontend
            $response = HandleFileUploadAction::run($lecture, $chunks->getFile());

            try {
                unlink($chunks->getFile()->getPathname());
            } catch(\Exception $e) {
                report($e);
                return false;
            }

            return response()->json($response);
        }
    }
}
