<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(UserResource::collection(User::latest()->get()),200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // $resource = User::findOrFail($user);
        return response()->json(new UserResource($user),200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        Validator::make($request->all(), [
            'name' => '',
            'surnames' => '',
            'avatar' => '',
            'email' => 'email',Rule::unique('users')->ignore($user->id),
            'password' => 'required|current_password',
            'new_password' => 'confirmed',
        ])->validate();

        if (Auth::id() !== $user->id) {
            return response()->json(['message' => 'No tienes los permisos necesarios'], 403);
        }

        if (!empty($request->input('avatar'))) {
            $user->avatar = $request->input('avatar');
        }
        if (!empty($request->input('name'))) {
            $user->name = $request->input('name');
        }
        if (!empty($request->input('surnames'))) {
            $user->surnames = $request->input('surnames');
        }
        if (!empty($request->input('email'))) {
            $user->email = $request->input('email');
        }
        if (!empty($request->input('new_password'))) {
            $user->password = bcrypt($request->input('new_password'));
        }

        $res = $user->save();

        if ($res) {
            return response()->json(['message' => 'Usuario actualizado correctamente'],200);
        }

        return response()->json(['message' => 'Error al actualizar usuario'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //TODO: pedir contrase??a para borrar

        // Validator::make($request->all(), [
        //     'password' => 'required|current_password'
        // ])->validate();

        if (Auth::id() !== $user->id) {
            return response()->json(['message' => 'No tienes los permisos necesarios'], 403);
        }

        $user->erased=true;

        $res = $user->save();

        if ($res) {
            return response()->json(['message' => 'Usuario eliminado correctamente']);
        }

        return response()->json(['message' => 'Error al eliminar usuario'], 500);
    }

}
