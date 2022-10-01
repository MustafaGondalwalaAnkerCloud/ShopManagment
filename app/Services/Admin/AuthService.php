<?php

namespace App\Services\Admin;

use App\Models\Admin;
use Exception;

/**
 * Class AdminAuthService.
 */
class AuthService
{
    public function login($email, $password)
    {
        if (auth()->guard('admin')->attempt(['email' => $email, 'password' => $password])) {
            return true;
        } else {
            throw new Exception('Invalid Email or Password');
        }
    }

    public function direct_login($email)
    {
        $admin_user = Admin::where(['email' => $email])->firstOrFail();
        auth()->guard('admin')->loginUsingId($admin_user->id);
    }
}
