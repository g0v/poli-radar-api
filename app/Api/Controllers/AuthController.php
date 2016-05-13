<?php

namespace Api\Controllers;

use App\User;
use App\Role;
use Dingo\Api\Facade\API;
use Illuminate\Http\Request;
use Api\Requests\UserRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Laravel\Socialite\Facades\Socialite;
use Api\Transformers\UserTransformer;

class AuthController extends BaseController
{
    /**
     * Show all politicians
     *
     * Get a JSON representation of all the politicians
     * 
     * @Get('/')
     */
    public function index()
    {
        return $this->response->collection(User::all(), new UserTransformer);
    }

    /**
     * Store a new dog in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password)
        ]);

        if ($request->roles) {
            $user->roles()->attach($request->roles);
        }

        return $this->item($user, new UserTransformer);
    }

    public function me(Request $request)
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = User::where('email', '=', $request->email)->first();
        $roles = [];
        foreach ($user->roles()->get() as $role) {
            $roles[] = $role->name;
        }

        // all good so return the token
        return response()->json([
            'token' => $token,
            'roles' => $roles
        ]);
    }

    public function validateToken() 
    {
        // Our routes file should have already authenticated this token, so we just return success here
        return API::response()->array(['status' => 'success'])->statusCode(200);
    }

    public function register(Request $request)
    {
        $newUser = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ];
        $user = User::create($newUser);
        $token = JWTAuth::fromUser($user);

        if (isset($request->roles)) {
            foreach ($request->roles as $role_id) {
                $role = Role::find($role_id);
                $user->attachRole($role);
            }
        }

        $roles = [];
        foreach ($user->roles()->get() as $role) {
            $roles[] = $role->name;
        }

        // all good so return the token
        return response()->json([
            'token' => $token,
            'roles' => $roles
        ]);
    }
}