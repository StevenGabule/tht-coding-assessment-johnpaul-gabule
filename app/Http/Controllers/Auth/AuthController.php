<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{LoginRequest, RegisterRequest};
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return response()->json([
            "message" => "User registered successfully.",
            "data" => $success
        ]);
    }


    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if ($request->wantsJson()) {
            if (! Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
                throw ValidationException::withMessages([
                    'error' => __('auth.failed')
                ]);
            }

            $authUser = Auth::user();
            $data['token'] = $authUser->createToken(env('APP_NAME'))->plainTextToken;
            $data['name'] = $authUser->name;
            return response()->json([
                'message' => 'Welcome to ' . env('APP_NAME'),
                'authToken' => 'Authenticated',
                'data' => $data
            ]);
        }
        return response()->json([
            'error' => 'Incorrect username or password. Please check your credentials.'
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function profile(Request $request): JsonResponse
    {
        return response()->json(['user' => auth()->user()]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([], 204);
    }
}
