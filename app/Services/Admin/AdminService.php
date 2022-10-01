<?php

namespace App\Services\Admin;

use App\Models\Admin;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class AdminService.php.
 */
class AdminService
{
    public function datatable($request)
    {
        $data = Admin::latest();
        if ($request->name != '') {
            $data->where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->email != '') {
            $data->where('email', 'like', '%'.$request->email.'%');
        }

        return DataTables::of($data)
            ->addColumn('action', function ($value) {
                $editRoute = route('admin.add', ['admin' => $value->encrypted_id]);
                $deleteRoute = route('admin.delete', ['admin' => $value->encrypted_id]);

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
            ->rawColumns(['action'])
            ->make(true);
    }
    public function addUpdate(Admin $admin, Array $data): Admin{
        return Admin::updateOrCreate(
            ['id' => $admin->exists == true ? $admin->id : null],
            $data
        );
    }
}
