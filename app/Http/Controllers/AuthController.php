<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->email && $request->name && $request->password) {
            if (count(User::where('email', "=", $request->email)->get()) > 0 || count(User::where('name', "=", $request->name)->get()) > 0) {
                return response()->json('Wystąpił błąd. Użytkownik o takim adresie e-mail lub loginie już istnieje.', 422);
            }
            $token = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
            $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'remember_token' => $token,
            ]);
            return [
                'user' => $user,
                'token' => $token,
            ];
        } else {
            return response()->json('Wystąpił błąd. Wymagane pole/a nieuzupełnione.', 422);
        }
    }



    /**
     * User Login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if ($request->email && $request->password) {
            if (count(User::where('email', "=", $request->email)->get()) == 0) {
                return response()->json('Wystąpił błąd. Brak użytkownika o takim adresie e-mail.', 422);
            }
            $user = User::where('email', "=", $request->email)->get();
            if (Hash::check($request->password, $user[0]->password)) {
                if (!$user[0]->active) {
                    return response()->json('Wystąpił błąd. Twoje konto jest nieaktywne.', 422);
                }
                $token = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(24 / strlen($x)))), 1, 24);
                User::where('email', "=", $request->email)->update([
                    'remember_token' => $token,
                ]);
                return [
                    'user' => User::where('email', "=", $request->email)->get(),
                    'token' => $token,
                ];
            } else {
                return response()->json('Wystąpił błąd. Nieprawidłowe hasło.', 422);
            }
        } else {
            return response()->json('Wystąpił błąd. Wymagane pole/a nieuzupełnione.', 422);
        }
    }

    public function logout(Request $request)
    {
        return  User::where('remember_token', "=", $request->remember_token)->update([
            "remember_token" => "",
        ]);
    }

    public function auth(Request $request)
    {
        $user = User::where('remember_token', "=", $request->remember_token)->get();
        if (!$user) {
            return '';
        } else {
            if (!$user[0]->active) {
                return '';
            } else {
                return $user;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}