<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Trainer;
use App\Models\Users;
use App\Models\UsersWithRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TrainerController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/register/trainer",
     * description="Sign up as trainer",
     * operationId="trainertRegister",
     * tags={"Sign up"},
     * @OA\RequestBody(
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password", "first_name", "last_name", "phone"},
     *       @OA\Property(property="email", type="string", format="email", example="traine@mail.ru"),
     *       @OA\Property(property="password", type="string", format="password", example="traine"),
     *       @OA\Property(property="first_name", type="string", format="text", example="First name"),
     *       @OA\Property(property="last_name", type="string", format="text", example="Last name"),
     *       @OA\Property(property="phone", type="number", example="+374 98-066-083"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:2',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = Users::create([
            'email' => $validator->validated()['email'],
            'password' => Hash::make($validator->validated()['password']),
        ]);

        $trainer = Trainer::create([
            'email' => $validator->validated()['email'],
            'password' => Hash::make($validator->validated()['password']),
            'first_name' => $validator->validated()['first_name'],
            'last_name' => $validator->validated()['last_name'],
            'phone' => $validator->validated()['phone'],
            'user_id' => $user->id
        ]);

        UsersWithRole::create([
            'user_id' => $user->id,
            'role_id' => 2
        ]);
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


}
