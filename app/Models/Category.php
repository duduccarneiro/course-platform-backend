<?php

namespace App\Models;

use App\Traits\WithHashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasFactory;
    use WithHashId;
    use HasRecursiveRelationships;

    protected $fillabel = [
        'name',
        'slug',
        'parent_id',
        'sort_order'
    ];
}
