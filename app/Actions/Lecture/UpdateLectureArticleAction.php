<?php

namespace App\Actions\Lecture;

use App\Models\Lecture;
use App\Data\Lecture\LectureArticleContentData;
use App\Enums\LectureType;

class UpdateLectureArticleAction
{
    public static function run(LectureArticleContentData $data, Lecture $lecture)
    {
        return tap($lecture)->update([
            'body' => $data->body,
            'type' => LectureType::TEXT,
            'duration_in_minutes' => self::calculateArticleReadingTime($data->body)
        ]);
    }

    protected static function calculateArticleReadingTime(string $text)
    {
        $word_count = str_word_count(strip_tags($text));
        return round($word_count / 200, 2);
    }
}
