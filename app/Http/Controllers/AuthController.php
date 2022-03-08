<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Registro de usuario
    */
    public function signup(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'surnames' => 'required',
            'nick' => 'required|unique:users,nick',
            'dni' => 'required|min:8|unique:users,dni',
            'avatar' => 'image|max:1024',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed', //pasword_confirmation
        ])->validate();

        $input = $request->all();

        if (!empty($request->file('avatar'))) {
            $url_image = $this->upload($request->file('avatar'));
        } else {
            $url_image = 'images/user/default.jpg';
        }
        $input['avatar']  = $url_image;

        //ciframos el password
        $input['password'] = bcrypt($request->input('password'));

        $user = User::create($input);
        Wallet::create([
            'amount' => 0,
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'Usuario creado',], 201);
    }

    /**
     * Inicio de sesión y creación de token
     */
    public function login(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ])->validate();

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json(['message' => 'Email y/o contraseña incorrectos'], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out'],201);
    }

    /**
     * Obtener el objeto User como json
     */
    public function user(Request $request)
    {
        $me = User::findOrFail($request->user()->id);

        return response()->json(new UserResource($me), 200);
    }

    private function upload($image)
    {
        $path_info = pathinfo($image->getClientOriginalName());
        $image_path = 'images/user';

        $rename = uniqid() . '.' . $path_info['extension'];
        $image->move(public_path() . "/$image_path", $rename);
        return "$image_path/$rename";
    }
}
