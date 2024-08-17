<?php

namespace App\Actions\Lecture;

use App\Enums\LectureType;
use App\Models\Lecture;
use Illuminate\Http\UploadedFile;

class HandleFileUploadAction
{
    public static function run(Lecture $lecture, UploadedFile $file)
    {
        tap($lecture->video, function($previous) use ($file, $lecture) {

            $temp_disk = config('site.disks.videos.temp');
            $stream_disk = config('site.disks.videos.stream');
            $mime_type = config('site.extensions.stream_mimetype');

            // move the video to a temporary directory
            $path = $file->store($lecture->id, $temp_disk);
            $name = $file->getClientOriginalName();

            $video = $lecture->video()->create([
                'original_file_name' => $name,
                'temp_path' => $path,
                'temp_disk' => $temp_disk,
                'stream_disk' => $stream_disk,
                'mime_type' => $mime_type,
                'processing_percent' => 0,
                'uploaded_at' => now()
            ]);

            $previous?->delete();

            $lecture->update([
                'type' => LectureType::VIDEO,
                'body' => null,
                'duration_in_minutes' => 0
            ]);

            // dispatch a job to process the video
        });

        return $lecture->fresh()->video;
    }
}
