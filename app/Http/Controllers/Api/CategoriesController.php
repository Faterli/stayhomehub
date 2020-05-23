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
                     CategoryResource::collection(Category::where('parentId',0)->get())
                  ],
         ]);
    }
    public function list(Request $request)
    {
        $categoryid = $request->category_id;

        $list = Category::where(['parentId'=>$categoryid])->get();

        $_list = ['list'=>$list];
        return response()->json([
                 'code' => 200,
                 'message' => '',
                 'result' =>$_list,
         ]);
    }
}
