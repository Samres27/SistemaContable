<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
class LoginController extends Controller
{
    public function showLoginForm()
    {
        
        return view('auth.login');
    }
    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'name' => ['required', 'max:20'],
            'password' => ['required'],
        ]);
        
        if (Auth::attempt($credentials)) {
            
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
        
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}