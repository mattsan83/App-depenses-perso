<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query();
        if ($request->query('type')) {
            $categories->where('type', $request->query('type'));
        }
        return CategoryResource::collection($categories->get());
    }

}
