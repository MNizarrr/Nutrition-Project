<?php

namespace App\Http\Controllers;
use App\Exports\UserExport;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')->get();
        return view('admin.user.index', compact('users'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:5',
            'last_name' => 'required|min:5',
            'gender' => 'required|in:L,P',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:8',
            'date_of_birth' => 'required|date',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
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
            'date_of_birth.required' => 'Tanggal lahir wajib di isi',
            'date_of_birth.date' => 'Format tanggal lahir tidak valid',
            'profile_image.image' => 'File harus berupa gambar',
            'profile_image.mimes' => 'Foto harus berupa jpg/jpeg/png/svg/webp',
            'profile_image.max' => 'Ukuran foto maksimal 2MB'
        ]);

        // Handle photo upload jika ada
        $path = null;
        if ($request->hasFile('profile_image')) {
            $photo = $request->file('profile_image');
            $namaFile = Str::random(10) . "-profile." . $photo->getClientOriginalExtension();
            $path = $photo->storeAs("profile", $namaFile, "public");
        }

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
            'role_id' => 3, // role 'user'
            'date_of_birth' => $request->date_of_birth,
            'profile_image' => $path
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
            if (Auth::user()->role->name == 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Berhasil Login!');
            } elseif (Auth::user()->role->name == 'teacher') {
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

    public function profile()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Upload profile photo.
     */
    public function uploadPhoto(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'photo' => 'required|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ], [
            'photo.required' => 'Foto profil harus di isi',
            'photo.mimes' => 'Foto harus berupa jpg/jpeg/png/svg/webp',
            'photo.max' => 'Ukuran foto maksimal 2MB'
        ]);

        $user = Auth::user();

        //ambil file nya
        $photo = $request->file('photo');

        // Hapus foto lama jika ada
        if ($user->profile_image) {
            $filePath = storage_path('app/public/' . $user->profile_image);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // buat nama baru untuk file nya
        // format file baru yang di harapkan acak : <acak>-profile.jpg
        // getClientOriginalExtension() : mengambil ekstensi file yang di upload
        $namaFile = Str::random(10) . "-profile." . $photo->getClientOriginalExtension();

        //simpan file ke folder storage : store AS("namasubfolder", namafile, "visibility")
        $path = $photo->storeAs("profile", $namaFile, "public");

        $updateData = $user->update([
            'profile_image' => $path
        ]);

        if ($updateData) {
            return redirect()->route('profile.index')->with('success', 'Foto profil berhasil diupload!');
        } else {
            return redirect()->back()->with('error', 'Gagal! Silahkan coba lagi.');
        }
    }

    /**
     * Update profile photo.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ], [
            'photo.required' => 'Foto profil harus di isi',
            'photo.mimes' => 'Foto harus berupa jpg/jpeg/png/svg/webp',
            'photo.max' => 'Ukuran foto maksimal 2MB'
        ]);

        $user = Auth::user();

        //jika input file photo di isi
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_image) {
                $filePath = storage_path('app/public/' . $user->profile_image);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $file = $request->file('photo');
            $fileName = Str::random(10) . "-profile." . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile', $fileName, 'public');
        }

        $updateData = $user->update([
            'profile_image' => $path
        ]);

        if ($updateData) {
            return redirect()->route('profile.index')->with('success', 'Foto profil berhasil diperbarui!');
        } else {
            return redirect()->back()->with('error', 'Gagal, silahkan coba lagi.');
        }
    }

    /**
     * Delete profile photo.
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->profile_image) {
            $filePath = storage_path('app/public/' . $user->profile_image);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $deleteData = $user->update([
                'profile_image' => null
            ]);

            if ($deleteData) {
                return redirect()->route('profile.index')->with('success', 'Foto profil berhasil dihapus!');
            } else {
                return redirect()->back()->with('error', 'Gagal menghapus foto!');
            }
        }

        return redirect()->back()->with('error', 'Tidak ada foto untuk dihapus!');
    }

    /**
     * Show form for editing profile photo.
     */
    public function editPhoto()
    {
        $user = Auth::user();
        return view('profile.edit-photo', compact('user'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:5',
            'last_name' => 'required|min:5',
            'gender' => 'required|in:L,P',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:8',
            'role_id' => 'required|exists:roles,id',
            'date_of_birth' => 'required|date',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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
            'role_id.required' => 'Role wajib dipilih',
            'role_id.exists' => 'Role tidak valid',
            'date_of_birth.required' => 'Tanggal lahir wajib di isi',
            'date_of_birth.date' => 'Format tanggal lahir tidak valid',
            'profile_image.image' => 'File harus berupa gambar',
            'profile_image.mimes' => 'Foto harus berupa jpg/jpeg/png/webp',
            'profile_image.max' => 'Ukuran foto maksimal 2MB'
        ]);

        // Handle photo upload jika ada
        $path = null;
        if ($request->hasFile('profile_image')) {
            $photo = $request->file('profile_image');
            $namaFile = Str::random(10) . "-profile." . $photo->getClientOriginalExtension();
            $path = $photo->storeAs("profile", $namaFile, "public");
        }

        // Buat user
        $createData = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'date_of_birth' => $request->date_of_birth,
            'profile_image' => $path
        ]);

        if ($createData) {
            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dibuat!');
        } else {
            return redirect()->route('admin.users.create')->with('error', 'Gagal membuat pengguna! Silahkan coba lagi!');
        }
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
    public function edit($id = null)
    {
        if ($id) {
            // Admin editing a specific user
            $user = User::findOrFail($id);
            return view('admin.user.edit', compact('user'));
        } else {
            // Profile edit for logged-in user
            $user = Auth::user();
            return view('profile.edit', compact('user'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Check if admin is updating or user updating their own profile
        $isAdminUpdate = $request->has('role_id') || $request->has('email');

        if ($isAdminUpdate) {
            // Admin update validation
            $request->validate([
                'first_name' => 'nullable|min:5',
                'last_name' => 'nullable|min:5',
                'email' => 'nullable|email:dns|unique:users,email,' . $id,
                'gender' => 'nullable|in:L,P',
                'role_id' => 'nullable|exists:roles,id',
                'date_of_birth' => 'nullable|date',
                'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ], [
                'first_name.min' => 'Nama depan harus di isi minimal 5 karakter',
                'last_name.min' => 'Nama Belakang harus di isi minimal 5 karakter',
                'email.email' => 'Email tidak valid',
                'email.unique' => 'Email sudah digunakan',
                'gender.in' => 'Jenis Kelamin tidak valid',
                'role_id.exists' => 'Role tidak valid',
                'date_of_birth.date' => 'Format tanggal lahir tidak valid',
                'profile_image.image' => 'File harus berupa gambar',
                'profile_image.mimes' => 'Foto harus berupa jpg/jpeg/png/webp',
                'profile_image.max' => 'Ukuran foto maksimal 2MB'
            ]);
        } else {
            // Profile update validation
            $request->validate([
                'first_name' => 'nullable|min:5',
                'last_name' => 'nullable|min:5',
                'gender' => 'nullable|in:L,P',
                'date_of_birth' => 'nullable|date',
                'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ], [
                'first_name.min' => 'Nama depan harus di isi minimal 5 karakter',
                'last_name.min' => 'Nama Belakang harus di isi minimal 5 karakter',
                'gender.in' => 'Jenis Kelamin tidak valid',
                'date_of_birth.date' => 'Format tanggal lahir tidak valid',
                'profile_image.image' => 'File harus berupa gambar',
                'profile_image.mimes' => 'Foto harus berupa jpg/jpeg/png/webp',
                'profile_image.max' => 'Ukuran foto maksimal 2MB'
            ]);
        }

        // Prepare update data
        $updateData = [];

        // Handle name update
        if ($request->filled('first_name') || $request->filled('last_name')) {
            $firstName = $request->first_name ?: explode(' ', $user->name)[0] ?? '';
            $lastName = $request->last_name ?: implode(' ', array_slice(explode(' ', $user->name), 1)) ?? '';
            $updateData['name'] = trim($firstName . ' ' . $lastName);
        }

        // Handle other fields
        if ($request->filled('email')) {
            $updateData['email'] = $request->email;
        }

        if ($request->filled('gender')) {
            $updateData['gender'] = $request->gender;
        }

        if ($request->filled('role_id')) {
            $updateData['role_id'] = $request->role_id;
        }

        if ($request->filled('date_of_birth')) {
            $updateData['date_of_birth'] = $request->date_of_birth;
        }

        // Handle photo upload jika ada
        if ($request->hasFile('profile_image')) {
            // Hapus foto lama jika ada
            if ($user->profile_image) {
                $filePath = storage_path('app/public/' . $user->profile_image);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $photo = $request->file('profile_image');
            $namaFile = Str::random(10) . "-profile." . $photo->getClientOriginalExtension();
            $path = $photo->storeAs("profile", $namaFile, "public");
            $updateData['profile_image'] = $path;
        }

        if (!empty($updateData)) {
            $user->update($updateData);
            if ($isAdminUpdate) {
                return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil diperbarui!');
            } else {
                return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
            }
        } else {
            return redirect()->back()->with('error', 'Tidak ada perubahan yang dilakukan.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Soft delete
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Show trashed users.
     */
    public function trash()
    {
        // onlytrashed() -> filter data yang sudah di hapus, delete_at BUKAN NULL
        $userTrash = User::onlyTrashed()->get();
        return view('admin.user.trash', compact('userTrash'));
    }

    /**
     * Export users to Excel.
     */
    public function export()
    {
        return Excel::download(new UserExport, 'users.xlsx');
    }

    /**
     * Restore a soft deleted user.
     */
    public function restore(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('admin.users.trash')->with('success', 'User berhasil direstore!');
    }

    /**
     * Permanently delete a user.
     */
    public function deletePermanent(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('admin.users.trash')->with('success', 'User berhasil dihapus permanen!');
    }
}
