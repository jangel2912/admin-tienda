<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Database\Tables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CrossLoginController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
	public function login(Request $request)
    {
    	$data = json_decode($this->decrypt($request->data), true);
    	$user = User::where('email', $data['email'])
            ->where('password', $data['password'])
            ->first();

    	if ($user) {
    		Auth::guard('admin')->login($user);

            (new Tables($user))->runAll();

    		return response()->json([
    			'status' => true
    		], 200);
    	} else {
    		return response()->json([
    			'status' => false
    		], 200);
    	}
    }

    /**
     * Encriptamos una cadena de caracteres
     *
     * @param string $string cadena que queremos encriptar
     * @return string Retorna una cadena encriptada
     */
	private function encrypt(string $string)
	{
		return openssl_encrypt($string, config('app.cipher'), env('HASH_PASS'), 0, "1234567812345678");
	}

    /**
     * Desencriptamos un Hash
     *
     * @param string $encrypted Hash que queremos desencriptar
     * @return string Retorna el valor del Hash desencriptado
     */
	private function decrypt(string $encrypted)
	{
        $encrypted = str_replace(' ', '', $encrypted);
        return openssl_decrypt($encrypted, config('app.cipher'), env('HASH_PASS'), 0, "1234567812345678");
	}
}
