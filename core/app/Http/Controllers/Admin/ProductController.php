<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function allProducts()
    {
        $products = Product::with('category')->latest()->paginate(getPaginate());
        $page_title = 'Products';
        $empty_message = 'No product has been added.';
        return view('admin.product.all_products', compact('page_title', 'empty_message', 'products'));
    }

    public function runningProducts()
    {
        $products = Product::where('start_date', '<', now())->where('end_date', '>', now())->with('category')->latest()->paginate(getPaginate());
        $page_title = 'Bid Running Products';
        $empty_message = 'No running product.';
        return view('admin.product.all_products', compact('page_title', 'empty_message', 'products'));
    }

    public function upcomingProducts()
    {
        $products = Product::where('start_date', '>', now())->where('end_date', '>', now())->with('category')->latest()->paginate(getPaginate());
        $page_title = 'Bid Upcoming Products';
        $empty_message = 'No upcoming product.';
        return view('admin.product.all_products', compact('page_title', 'empty_message', 'products'));
    }

    public function expiredProducts()
    {
        $products = Product::where('start_date', '<', now())->where('end_date', '<', now())->with('category')->latest()->paginate(getPaginate());
        $page_title = 'Bid Expired Products';
        $empty_message = 'No expired product.';
        return view('admin.product.all_products', compact('page_title', 'empty_message', 'products'));
    }

    public function bidCompletedProducts()
    {
        $products = Product::where('bid_complete', 1)->with('category')->latest()->paginate(getPaginate());
        $page_title = 'Bid Completed Products';
        $empty_message = 'No product.';
        return view('admin.product.all_products', compact('page_title', 'empty_message', 'products'));
    }

    public function addProduct()
    {
        $page_title = 'Add Product';
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.product.add_products', compact('page_title', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'start_date' => 'required|date_format:"Y-m-d h:i a"|after_or_equal:today',
            'end_date' => 'required|date_format:"Y-m-d h:i a"|after:start_date',
            'min_bid_price' => 'required|numeric|gt:0',
            'shipping_cost' => 'required|numeric|min:0',
            'delivery_time' => 'required|string',
            'description' => 'required|string',
            'keywords.*' => 'required|string',
            'title.*' => 'required|string',
            'content.*' => 'required|string',
            'images.*' => ['required', 'max:10000', new FileTypeValidate(['jpeg','jpg','png','gif'])]
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->start_date = Carbon::create($request->start_date);
        $product->end_date = Carbon::create($request->end_date);
        $product->min_bid_price = $request->min_bid_price;
        $product->shipping_cost = $request->shipping_cost;
        $product->delivery_time = $request->delivery_time;
        $product->keywords = $request->keywords;
        $product->description = $request->description;
        if (!$request->title) {
            $notify[] = ['error', 'Have to put minimum 1 other information'];
            return back()->withNotify($notify);
        }
        foreach ($request->title as $key => $item) {
            $others_info[$item] = $request->content[$key];
        }
        $product->others_info = $others_info;
        // Upload image
        foreach ($request->images as $image) {
            $path = imagePath()['products']['path'];
            $size = imagePath()['products']['size'];
            $images[] = uploadImage($image, $path, $size);
        }
        $product->images = $images;

        $product->save();

        $notify[] = ['success', 'Product Added Successfully!'];
        return back()->withNotify($notify);
    }

    public function editProduct(Product $product)
    {
        if ($product->bid_complete === 1){
            $notify[] = ['error', 'Bid Completed Product Not Editable!'];
            return back()->withNotify($notify);
        }
        $page_title = 'Edit Product';
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.product.edit_products', compact('page_title', 'categories', 'product'));
    }

    public function updateProduct(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'start_date' => 'required|date_format:"Y-m-d h:i a"|before:end_date',
            'end_date' => 'required|date_format:"Y-m-d h:i a"|after:start_date',
            'min_bid_price' => 'required|numeric|gt:0',
            'shipping_cost' => 'required|numeric|min:0',
            'delivery_time' => 'required|string',
            'description' => 'required|string',
            'keywords.*' => 'required|string',
            'title.*' => 'required|string',
            'content.*' => 'required|string',
            'images.*' => ['required', 'max:10000', new FileTypeValidate(['jpeg','jpg','png','gif'])]
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->start_date = Carbon::create($request->start_date);
        $product->end_date = Carbon::create($request->end_date);
        $product->min_bid_price = $request->min_bid_price;
        $product->shipping_cost = $request->shipping_cost;
        $product->delivery_time = $request->delivery_time;
        $product->keywords = $request->keywords;
        $product->description = $request->description;
        if (!$request->title) {
            $notify[] = ['error', 'Have to put minimum 1 other information'];
            return back()->withNotify($notify);
        }
        foreach ($request->title as $key => $item) {
            $others_info[$item] = $request->content[$key];
        }
        $product->others_info = $others_info;

        // Upload and Update image
        if ($request->images){
            foreach ($request->images as $image) {
                $path = imagePath()['products']['path'];
                $size = imagePath()['products']['size'];

                $images[] = uploadImage($image, $path, $size);
            }
            $product->images = array_merge($product->images, $images);
        }

        $product->save();

        $notify[] = ['success', 'Product Updated Successfully!'];
        return back()->withNotify($notify);
    }

    public function deleteProductImage($id, $image)
    {
        $product = Product::findOrFail($id);

        $images = [];
        foreach ($product->images as $item) {

            if ($item == $image){
                $path = imagePath()['products']['path'];
                removeFile($path.'/' . $image);
                continue;
            }

            $images[] = $item;
        }

        $product->images = $images;
        $product->save();

        return response()->json(['success' => true, 'message' => 'Product image deleted!']);
    }

    public function productStatus ($id)
    {
        $product = Product::findOrFail($id);
        $product->status = ($product->status ? 0 : 1);
        $product->save();

        $notify[] = ['success', 'Product '. ($product->status ? 'Activated!' : 'Deactivated!')];
        return back()->withNotify($notify);
    }

    // Search Products
    public function productSearch(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string'
        ]);

        $search = $request->product_name;
        $products = Product::with(['category'])->where('name', 'LIKE', "%{$search}%")->paginate(getPaginate());

        $page_title = 'Search Result';
        $empty_message = 'No product found.';
        return view('admin.product.all_products', compact('page_title', 'empty_message', 'products'));
    }
}
