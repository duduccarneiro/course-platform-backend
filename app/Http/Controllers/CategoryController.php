<?php

namespace App\Http\Controllers;

use App\Actions\Category\GetAllCategoriesAction;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __invoke()
    {
        $categories = GetAllCategoriesAction::run();

        return CategoryResource::collection($categories);
    }
}
