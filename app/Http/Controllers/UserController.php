<?php

namespace App\Http\Controllers;
use App\Exports\UserExport;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereIn('role', ['admin', 'staff'])->get();
        return view('admin.user.index', compact('users'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:5',
            'last_name' => 'required|min:5',
            'gender' => 'required|in:L,P',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:8'
        ], [
            'first_name.required' => 'Nama depan wajib di isi',
            'first_name.min' => 'Nama depan harus di isi minimal 5 karakter',
            'last_name.required' => 'Nama Belakang wajib di isi',
            'last_name.min' => 'Nama Belakang harus di isi minimal 5 karakter',
            'gender.required' => 'Jenis Kelamin wajib di isi',
            'gender.in' => 'Jenis Kelamin tidak valid',
            'email.required' => 'Email wajib di isi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib di isi',
            'password.min' => 'Password berisi minimal 8 karakter',
        ]);

        // Ambil role user dari tabel roles
        $userRole = \App\Models\Role::where('name', 'user')->first();

        if (!$userRole) {
            return back()->with('error', 'Role user tidak ditemukan. Pastikan sudah seed role.');
        }

        // Buat user
        $createData = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3 // role 'user'
        ]);


        if ($createData) {
            return redirect()->route('signin')->with('success', 'Berhasil membuat akun. Silahkan login!');
        } else {
            return redirect()->route('signup')->with('error', 'Gagal memperoleh data! Silahkan coba lagi!');
        }
    }

    public function authentication(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib di isi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password wajib di isi',
        ]);

        $data = $request->only(['email', 'password']);
        if (Auth::attempt($data)) {
            if (Auth::user()->role_id == 1) {
                return redirect()->route('admin.dashboard')->with('success', 'Berhasil Login!');
            } elseif (Auth::user()->role_id == 2) {
                return redirect()->route('teacher.dashboard')->with('success', 'Berhasil Login!');
            } else {
                return redirect()->route('home')->with('success', 'Berhasil Login!');
            }
        } else {
            return redirect()->back()->with('error', 'Gagal! Pastikan Email dan Password Benar');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('logout', 'Anda telah logout! Silahkan login kembali untuk akses lengkap');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
