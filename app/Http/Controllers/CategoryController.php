<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function save(Request $request)
    {
        $valid = $request->validate(
            [
                'title' => 'required|string'
            ]
        );

        if ($valid != null) {
            $category = new Category();
            $category->title = $valid['title'];
        }
    }
}
