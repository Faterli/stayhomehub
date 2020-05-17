<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoriesController extends Controller
{
    public function index()
    {
        CategoryResource::wrap('data');
         return response()->json([
                 'code' => 200,
                 'message' => '',
                 'result' => [
                     CategoryResource::collection(Category::all())
                  ],
         ]);
    }
}
