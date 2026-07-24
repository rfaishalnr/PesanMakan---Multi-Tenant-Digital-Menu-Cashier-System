<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;


class ProductController extends Controller
{
    public function show(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        $products = Product::where('id', $request->id)->first();

        if (!$products) {
            abort(404);
        }

        return view('pages.product', compact('store', 'products'));
    }

    public function find(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }

        return view('pages.find', compact('store'));
    }

    public function findResults(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if (!$store) {
            abort(404);
        }


        $products = Product::where('user_id', $store->id);

        if (isset($request->category) && $request->category != '') {
            // Ubah pencarian dari 'slug' menjadi 'id'
            $category = ProductCategory::where('user_id', $store->id)
                ->where('id', $request->category) 
                ->first();
            
            // Tambahkan if untuk memastikan $category ditemukan sebelum memanggil ->id
            if ($category) {
                $products = $products->where('product_category_id', $category->id);
            }
        }

        if (isset($request->search)) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $products->get();

        return view('pages.result', compact('store', 'products'));
    }
}
