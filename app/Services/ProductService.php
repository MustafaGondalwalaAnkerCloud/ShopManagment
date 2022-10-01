<?php

namespace App\Services;

use App\Models\Product;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class ProductService.php.
 */
class ProductService
{
    public function datatable($request)
    {
        $data = Product::latest();
        if ($request->name != '') {
            $data->where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->parent_id != '') {
            $data->where('parent_id', $request->parent_id);
        }

        return DataTables::of($data)
            ->addColumn('action', function ($value) {
                $editRoute = route('admin.category.add', ['category' => $value->encrypted_id]);
                $deleteRoute = route('admin.category.delete', ['category' => $value->encrypted_id]);

                $editButton = '<a class="btn btn-sm btn-warning" href="'.$editRoute.'">Edit</a>';
                $deleteForm = '<form method="POST" action="'.$deleteRoute.'">
                            <input type="hidden" name="_method" value="delete" />
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                            <div class="form-group">
                                <input type="submit" class="btn btn-sm btn-danger" value="Delete" />
                            </div>
                        </form>';

                $buttons = $editButton.$deleteForm;

                return $buttons;
            })
            ->addColumn('status', function ($row) {
                return @$row->status == 1 ? 'Active' : 'InActive';
            })
            ->addColumn('isParentCategory', function ($row) {
                return @$row->parent_id == null ? 'true' : '';
            })
            ->rawColumns(['action','isParentCategory'])
            ->make(true);
    }
    public function addUpdate(Product $category, Array $data): Product{
        return Product::updateOrCreate(
            ['id' => $category->exists == true ? $category->id : null],
            $data
        );
    }
    public function allParentCategories(){
        return Product::where(['parent_id' => null, 'status' => true])->get();
    }
}
