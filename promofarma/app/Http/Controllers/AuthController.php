<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Create New User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4'
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->save();

        return response()->json([
            'data' => 'Successfully created user'
        ], Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     */
    public function login(Request $request)
    {
        // TODO
    }

    /**
     * @param Request $request
     */
    public function logout(Request $request)
    {
        // TODO
    }
}
