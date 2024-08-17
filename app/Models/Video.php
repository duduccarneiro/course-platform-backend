<?php

namespace App\Models;

use App\Enums\VideoStatus;
use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

use function Illuminate\Events\queueable;

class Video extends Model
{
    use HasFactory;
    use WithHashId;

    protected $fillable = [
        'lecture_id',
        'original_file_name',
        'temp_disk',
        'stream_disk',
        'temp_path',
        'stream_name',
        'processing_percent',
        'duration_seconds',
        'mime_type',
        'uploaded_at',
        'processing_ended_at',
        'status',
        'failure_details',
    ];

    protected $casts = [
        'status' => VideoStatus::class,
        'processing_ended_at' => 'datetime',
        'uploaded_at' => 'datetime'
    ];

    protected static function booted()
    {
        static::deleted(queueable(function($video) {
            Storage::disk($video->stream_disk)->deleteDirectory($video->id);
        }));
    }

    public function lecture() : BelongsTo
    {
        return $this->belongsTo(Lecture::class);
    }
}
