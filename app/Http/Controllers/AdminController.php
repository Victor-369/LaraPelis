<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peli;
use App\Models\User;
use App\Models\Role;


class AdminController extends Controller
{
    public function deletedPelis() {
        $pelis = Peli::onlyTrashed()->paginate(config('pagination.pelis', 10));

        return view('admin.pelis.deleted', ['pelis' => $pelis]);
    }

    // lista de usuarios
    public function userList() {
        $users = User::orderBy('name', 'ASC')->paginate(config('pagination.users', 10));

        return view('admin.users.list', ['users' => $users]);
    }

    public function userShow(User $user) {
        // carga la vista de detalle y le pasa el usuario recuperado
        return view('admin.users.show', ['user' => $user]);
    }

    public function userSearch(Request $request) {
        $request->validate(['name' => 'max:32', 'email' => 'max:32']);

        // toma los valores que llegan para el nombre y email
        $name = $request->input('name', '');
        $email = $request->input('email', '');

        // recupera los resultados
        $users = User::orderBy('name', 'ASC')
                    ->where('name', 'like', "%$name%")
                    ->where('email', 'like', "%$email%")
                    ->paginate(config('pagination.users'))
                    ->appends(['name' => $name, 'email' => $email]);
        
        return view('admin.users.list', ['users' => $users
                                        ,'name' => $name
                                        ,'email' => $email]);
    }

    // añadir rol a usuario
    public function setRole(Request $request) {
        $role = Role::find($request->input('role_id'));
        //$user = Role::find($request->input('user_id'));

        $user = User::where('id', $request->user_id)->first();

        // intenta añadir el rol
        try {
            $user->roles()->attach($role->id, [
                                                'created_at' => now(),
                                                'updated_at' => now()
                                            ]);
            
            return back()->with('success', "Rol $role->role añadido a $user->name correctamente.");
        } catch (QueryException $e) {
            return back()->withErrors("No se pudo añadir el rol $role->role a $user->name. Es posible que ya lo tenga.");
        }
    }

    public function removeRole(Request $request) {
        $role = Role::find($request->input('role_id'));
        //$user = Role::find($request->input('user_id'));
        
        $user = User::where('id', $request->user_id)->first();

        // intenta quitar el rol
        try {
            $user->roles()->detach($role->id);
            
            return back()->with('success', "Rol $role->role quitado a $user->name correctamente.");
        } catch (QueryException $e) {
            return back()->withErrors("No se pudo quitar el rol $role->role a $user->name.");
        }
    }
}
