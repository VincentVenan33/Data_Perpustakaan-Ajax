<?php

namespace App\Http\Controllers;

use App\Models\UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        } else {
            return view('auth/login');
        }
    }

//     public function actionlogin(Request $request)
// {
//     $data = [
//         'email' => $request->input('email'),
//         'password' => $request->input('password'),
//     ];

//     $credentials = [
//         'email' => $request->input('email'),
//         'password' => $request->input('password'),
//     ];

//     if (Auth::attempt($credentials)) {
//         $user = Auth::user();

//         if ($user->status == 0) {
//             Auth::logout();
//             return redirect('auth/login')->with('error', 'Akun Nonaktif!');
//         }

//         $request->session()->regenerate();

//         $message = 'Selamat datang, ' . $user->name . '!';
//         return redirect('posts.index')->with('message', $message);
//     } else {
//         $user = UsersModel::where('email', $request->input('email'))->first();

//         if ($user) {
//             return redirect('auth/login')->with('error', 'Password Salah!');
//         } else {
//             return redirect('auth/login')->with('error', 'Email Salah!');
//         }
//     }
// }
public function actionlogin(Request $request)
    {
        $email      = $request->input('email');
        $password   = $request->input('password');

        if(Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
            return response()->json([
                'success' => true
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Login Gagal!'
            ], 401);
        }

    }


    public function actionlogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Use route helper with the named route
        return redirect()->route('login')->with('message','Berhasil Logout!');
    }
}