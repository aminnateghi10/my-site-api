<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Cookie;

class AuthController extends Controller
{

    /**
     * login
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws Exception
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if ($user === null) {
            return response()->json(['authenticate' => false], 401);
        }

        if (Hash::check($request->input('password'), $user->password)) {
            $apikey = base64_encode(bin2hex(random_bytes(40)));

            User::where('email', $request->input('email'))->update(['api_token' => $apikey]);

            return response()->json(['status' => 'success', 'token' => $apikey])
                ->withCookie(Cookie::create('user_token', $apikey));
        } else {
            return response()->json(['status' => 'fail'], 401);
        }
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::whereEmail($request->email)->first();

        if ($user) {
            abort(404);
        }

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => app('hash')->make('a13801380')
        ]);
    }

    public function checkAuth()
    {
        $user = auth()->user();

        return response()->json([
            'data' => $user,
            'status' => 'status'
        ]);
    }
}
