<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use WithFaker;

    public function register()
    {
        $faker = $this->makeFaker();
        $name = $faker->name;

        $credentials = [
            'email' => $faker->email,
            'password' => $faker->firstName,
            'name' => $name
        ];

        $user = new User($credentials);
        $status = $user->saveOrFail();

        event(new \App\Events\EventoTest($user));

        return response()->json(['message' => $status ? 'Criado com sucesso' : 'Erro ao criar']);
    }

    public function change(Request $req, $id)
    {
        $user = User::where('id', $id)->first();
        $user->name = $req->get('name');
        $user->save();
            
        event(new \App\Events\Change($user));
    }
}
