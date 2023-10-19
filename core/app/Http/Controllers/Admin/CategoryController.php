<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        $page_title = 'Categories';
        $empty_message = 'No category has been added.';
        return view('admin.category.index', compact('page_title', 'empty_message', 'categories'));
    }

    public function store(Request $request, Category $category)
    {
        $request->validate([
            'icon' => 'required|string',
            'name' => 'required|string|unique:categories,name'
        ]);

        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->save();

        $notify[] = ['success', 'Category Added'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'icon' => 'required|string',
            'name' => 'required|string|unique:categories,name,'.$category->id
        ]);

        $category->icon = $request->icon;
        $category->name = $request->name;
        $category->save();

        $notify[] = ['success', 'Category Updated'];
        return back()->withNotify($notify);
    }

    public function status(Category $category)
    {
        $category->status = ($category->status ? 0 : 1);
        $category->save();

        $notify[] = ['success', 'Category '. ($category->status ? 'Activated!' : 'Deactivated!')];
        return back()->withNotify($notify);
    }
}
