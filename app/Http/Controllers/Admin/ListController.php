<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminService;
use App\Models\Admin;
use App\Http\Requests\Admin\AdminStore;
use Illuminate\Http\Request;

class ListController extends Controller
{
    protected $adminService;

    protected $admin;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
        $this->middleware(function ($request, $next) {
            $this->admin = auth()->guard('admin')->user();

            return $next($request);
        });
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            return $this->adminService->datatable($request);
        }
        if ($request->isMethod('GET')) {
            return view('admin.auth.list');
        }
    }
    public function add(Request $request, Admin $admin)
    {
        return view('admin.auth.add', compact('admin'));
    }

    public function store(AdminStore $request, Admin $admin)
    {
        try {
            logger()->info('Admin Add/Edit', ['admin' => $admin->toArray()]);

            $addData = $request->only([
                'name',
                'email',
                'status',
                'email',
                'password'
            ]);
            $this->adminService->addUpdate($admin, $addData);
            return redirect()->route('admin.list')->with('message', 'Admin Updated Successfully');
        } catch (\Exception $e) {
            logger()->error('Admin Add/Edit Error', ['admin' => $admin->toArray(), $request->all()]);

            return back()->with('message', 'Error Occured');
        }
    }
    public function delete(Admin $admin){
        try {
            logger()->info('Admin Delete', ['admin' => $admin->toArray()]);

            $admin->delete();

            return redirect()->route('admin.list')->with('message', 'Admin Deleted Successfully');
        } catch (\Exception $e) {
            logger()->error('Admin Delete Error', ['admin' => $admin->toArray()]);

            return back()->with('message', 'Error Occured');
        }
    }
}
