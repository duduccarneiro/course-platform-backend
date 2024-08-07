<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;
    use WithHashId;

    protected $fillable = [
        'course_id',
        'title',
        'sort_order'
    ];

    public function course() : BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function lectures() : HasMany
    {
        return $this->hasMany(Lecture::class);
    }
}
