<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $products = Product::with('category:id,name')  // Load category name
                ->select(['id', 'category_id', 'name', 'description', 'price']);

            return DataTables::of($products)
                ->addColumn('category_name', function ($product) {
                    // Return the category name
                    return $product->category->name;
                })
                ->addColumn('actions', function ($product) {
                    return '
                    <a href="' . route('products.edit', $product) . '" class="btn btn-warning btn-sm">Edit</a>
                    <form action="' . route('products.destroy', $product) . '" method="POST" class="delete-form" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('products.index');

    }

    public function create()
    {
        $categories = \App\Models\Category::all();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);
        Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Product Created Successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Product Updated Successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product Deleted Successfully.');
    }
}
