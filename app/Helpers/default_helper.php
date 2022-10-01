<?php

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

function encrypt_param($parameter)
{
    if ($parameter == null) {
        return null;
    }

    return Crypt::encryptString($parameter);
}
function decrypt_param($parameter)
{
    if ($parameter == null) {
        return null;
    }
    try {
        $decrypt_parameter = Crypt::decryptString($parameter);
    } catch (DecryptException $e) {
        return $parameter;
    }

    return $decrypt_parameter;
}

function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) {
        return $min;
    } // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);

    return $min + $rnd;
}
function getToken($length = 10)
{
    $token = '';
    $codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codeAlphabet .= 'abcdefghijklmnopqrstuvwxyz';
    $codeAlphabet .= '0123456789';
    $max = strlen($codeAlphabet); // edited

    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max - 1)];
    }

    return $token;
}
function successResponse($data)
{
    return response()->json([
        'success' => true,
        'data' => $data,
    ], 200);
}
function errorResponse($data)
{
    return response()->json([
        'success' => false,
        'data' => $data,
    ], 400);
}

function custom($string)
{
    return config('custom.'.$string);
}

function uploadFile($file, $path)
{
    $filename = rand(1, 1000000).'_'.pathinfo(clean($file->getClientOriginalName()), PATHINFO_FILENAME).'.'.$file->getClientOriginalExtension();

    Storage::disk('public')->putFileAs(
        $path,
        $file,
        $filename
    );

    return url('storage'.$path.$filename);
}
