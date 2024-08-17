<?php

namespace App\Models;

use App\Enums\LectureType;
use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lecture extends Model
{
    use HasFactory;
    use WithHashId;

    protected $fillable = [
        'duration_in_minutes',
        'course_id',
        'section_id',
        'sort_order',
        'title',
        'type',
        'body',
    ];

    protected $casts = [
        'type' => LectureType::class,
        'duration_in_minutes' => 'float'
    ];

    public function course() : BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function section() : BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function video() : HasOne
    {
        return $this->hasOne(Video::class);
    }
}
