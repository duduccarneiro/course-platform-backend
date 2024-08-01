<?php

namespace App\Http\Controllers;

use App\Actions\Category\GetAllCategories;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __invoke()
    {
        $categories = GetAllCategories::run();

        return CategoryResource::collection($categories);
    }
}
