<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserPost;
use App\Http\Requests\UpdateUserPut;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');        
        $users = User::query()
            ->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->get();
        return Inertia::render('User/Index', [
            'users' => $users,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserPost $request)
    {
        $validatedData = $request->validated();
        Session::flash('message', 'El usuario a sido creado');

        // Hash la contraseña antes de guardarla
        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);
        return Inertia::location(route('user.index')); // Redirigir utilizando Inertia.js
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return Inertia::render('User/Show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return Inertia::render('User/Edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserPut $request, User $user)
    {
        $validatedData = $request->validated();
        Session::flash('message', 'El usuario a sido editado');
        // Si se modifica la contraseña, hasheala antes de actualizar
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        $user->update($validatedData);
        return Inertia::location(route('user.index')); // Redirigir utilizando Inertia.js
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        Session::flash('message', 'El usuario a sido eliminado');
        return Inertia::location(route('user.index')); // Redirigir utilizando Inertia.js
    }
}
