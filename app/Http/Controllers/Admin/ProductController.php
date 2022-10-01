<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminService;
use App\Models\Admin;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Str;

class ProductController extends Controller
{
    protected $adminService;
    protected $categoryService;
    protected $productService;

    protected $admin;

    public function __construct(AdminService $adminService, CategoryService $categoryService, ProductService $productService)
    {
        $this->adminService = $adminService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;

        
        $this->middleware(function ($request, $next) {
            $this->admin = auth()->guard('admin')->user();

            return $next($request);
        });
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            return $this->productService->datatable($request);
        }
        if ($request->isMethod('GET')) {
            $allParentCategories = $this->categoryService->allParentCategories();
            return view('admin.product.list', compact('allParentCategories'));
        }
    }
    public function add(Request $request, Product $product)
    {
        $allParentCategories = $this->categoryService->allParentCategories();
        return view('admin.product.add', compact('product','allParentCategories'));
    }

    public function store(ProductRequest $request, Product $product)
    {
        try {
            logger()->info('Product Add/Edit', ['product' => $product->toArray()]);

            $addData = $request->only([
                'name',
                'sku',
                'model',
                'mrp',
                'description',
                'image',
                'sale_price',
                'category_id',
                'sub_category_id',
                'status',
            ]);
            $this->productService->addUpdate($product, $addData);
            return redirect()->route('admin.product.list')->with('message', 'Product Updated Successfully');
        } catch (\Exception $e) {
            dd($e);
            logger()->error('Product Add/Edit Error', ['product' => $product->toArray(), $request->all()]);

            return back()->with('message', 'Error Occured');
        }
    }
    public function delete(Product $product){
        try {
            logger()->info('Product Delete', ['product' => $product->toArray()]);

            $product->delete();

            return redirect()->route('admin.product.list')->with('message', 'Product Deleted Successfully');
        } catch (\Exception $e) {
            logger()->error('Product Delete Error', ['product' => $product->toArray()]);

            return back()->with('message', 'Error Occured');
        }
    }
}
