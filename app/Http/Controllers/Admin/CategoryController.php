<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminService;
use App\Models\Admin;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Str;

class CategoryController extends Controller
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
            return $this->categoryService->datatable($request);
        }
        if ($request->isMethod('GET')) {
            $allParentCategories = $this->categoryService->allParentCategories();
            return view('admin.category.list', compact('allParentCategories'));
        }
    }
    public function add(Request $request, Product $category)
    {
        $allParentCategories = $this->categoryService->allParentCategories();
        return view('admin.category.add', compact('category','allParentCategories'));
    }

    public function store(CategoryRequest $request, Product $category)
    {
        try {
            logger()->info('Product Add/Edit', ['category' => $category->toArray()]);

            $addData = $request->only([
                'name',
                'parent_id',
                'status',
            ]);
            $addData['slug'] = Str::slug($addData['name']);
            $this->categoryService->addUpdate($category, $addData);
            return redirect()->route('admin.category.list')->with('message', 'Product Updated Successfully');
        } catch (\Exception $e) {
            dd($e);
            logger()->error('Product Add/Edit Error', ['category' => $category->toArray(), $request->all()]);

            return back()->with('message', 'Error Occured');
        }
    }
    public function delete(Product $product){
        try {
            logger()->info('Product Delete', ['category' => $category->toArray()]);

            $category->delete();

            return redirect()->route('admin.category.list')->with('message', 'Product Deleted Successfully');
        } catch (\Exception $e) {
            logger()->error('Product Delete Error', ['category' => $category->toArray()]);

            return back()->with('message', 'Error Occured');
        }
    }
    public function getAllSubCategories(Request $request, Category $category){
        try {
            logger()->info('Get All Sub Categories', ['category' => $category->toArray()]);
            $category->load('subcategory');
            return [
                "message" => "All Sub Categories",
                "data" => $category->subcategory,
                "success" => true
            ];

        } catch (\Exception $e) {
            logger()->error('Get All Sub Categories Error', ['category' => $category->toArray(), $request->all()]);

            return back()->with('message', 'Error Occured');
        }
    }
}
