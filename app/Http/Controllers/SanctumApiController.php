<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ResidentRepository;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SanctumApiController extends Controller
{

    public function __construct(
        protected ResidentRepository $repo,
    ) {
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        $answer = [
            'token' => '',
            'error' => ''
        ];
        if (!$user || !Hash::check($request->password, $user->password)) {
            $answer['error'] = 'The provided credentials are incorrect.';
        } else {
            $this->invokeAllUserToken($user);
            $answer['token'] = $user->createToken($request->device_name)->plainTextToken;
        }

        return response()->json($answer);
    }

    private function invokeAllUserToken(User $user)
    {
        $user->tokens()->delete();
    }

    public function getUser(Request $request)
    {
        $answer = [
            'name' => $request->user()->name ?: "",
            'email' => $request->user()->email ?: ""
        ];
        return response()->json($answer);
    }

    public function updateUser(Request $request)
    {
        $answer = [
            'result' => ''
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            $answer['result'] = 'Error validation';
        } else {

            $validated = $validator->validated();
            $this->repo->updateUserSimple($request->user()->id, $validated);

            $answer['result'] = 'OK';
        }
        return response()->json($answer);
    }
}