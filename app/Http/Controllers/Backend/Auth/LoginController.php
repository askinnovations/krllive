<?php
namespace App\Http\Controllers\Backend\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; 



class LoginController extends Controller
{

    protected function guard()
    {
        return Auth::guard('admin');
    }
    
    public function showLoginForm()
    {
        return view('admin.login'); // Ensure this view exists
    }

    public function apiLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            $token = $admin->createToken('admin-token')->plainTextToken;
    
            return response()->json([
                'token' => $token,
                'admin' => $admin,
            ]);
        }
    
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function login(Request $request)
{
    // Validate request data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    // Check if admin exists
    $admin = Admin::where('email', $request->email)->first();

    if (!$admin) {
        return back()->withErrors(['email' => 'Admin not found.']); // ✅ Admin exists nahi to error
    }

    // Attempt login only if admin exists
    if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
        return redirect()->route('admin.dashboard');
    }

    return back()->withErrors(['email' => 'Invalid credentials.']); // ✅ Agar password galat to error
}


        
        public function logout(Request $request)
        {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            return redirect()->route('admin.login');
        }
}
