<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = DB::table('admins') -> paginate(5);
        return view('Manager.Admin.list') -> with('data',$data);
    }

    public function statistical() {
        return view('Manager.Admin.statistical');
    }

    public function view_login_admin()
    {
        //
        return view('Manager.Admin.login_admin');
    }

    public function return_back_home_admin()
    {
        //
        return view('Manager.Admin.home_admin');
    }

    public function return_back_home_admin_new()
    {
        //
        $pitchCount = DB::table('pitches')->count();

        $adminCount = DB::table('admins')->count();

        $yardcategoryCount = DB::table('yard_categories')->count();

        $customerCount = DB::table('customers')->count();

        $schedulingCount = DB::table('scheduling_froms')->count();

        return view('Manager.Admin.home_admin_new', compact('pitchCount','adminCount', 'yardcategoryCount', 'customerCount', 'schedulingCount'));
    }
    public function login_admin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if(Auth::guard('admin')->attempt($credentials)) {
         $admin = Auth::guard('admin')->user();
         session()->put('admin',$admin);
            return Redirect::route('home_admin_new');
        } else {
            return Redirect::back();
        }
        // Tìm kiếm tài khoản quản trị viên với email tương ứng
        // $admin = Admin::where('email', $credentials['email'])->first();
        // // Kiểm tra xem tài khoản quản trị viên có tồn tại không
        // if ($admin) {
        //     // Kiểm tra mật khẩu
        //     if (Hash::check($credentials['password'], $admin->password)) {
        //         // Mật khẩu đúng, chuyển hướng đến trang khác
        //         return redirect()->route('home_admin_new');
        //     }
        // }
        // Nếu email hoặc mật khẩu không đúng, chuyển hướng lại và hiển thị thông báo lỗi
        // return redirect()->back()->withInput()->withErrors(['email' => 'Invalid email or password']);
    }

    public function logout_admin() {
        Auth::guard('admin')->logout();
        session()->forget('admin');
        return Redirect::route('login_admin');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
      return view('Manager.Admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        //
        DB::table('admins')->insert([
            'name' => $request ->name,
            'email' => $request ->email,
            'password' => Hash::make($request ->password),
            'address' => $request ->address,
            'phone_number'=> $request ->phone_number,
        ]);
        return Redirect::route('admin.index') ->with('msg','Add Successfull');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        //
        $data = DB::table('admins') ->where('id',$id) ->get();
        return view('Manager.Admin.edit') ->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, String $id)
    {
        //
        DB::table('admins')->where('id',$id)
            ->update([
                'name' => $request ->name,
                'email' => $request ->email,
                'password' => Hash::make($request ->password),
                'address' => $request ->address,
                'phone_number'=> $request ->phone_number
            ]);
        return Redirect::route('admin.index') ->with('msg','Edit Successfull');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        //
        DB::table('admins') ->delete($id);
        return Redirect::route('admin.index') ->with('msg','Delete Successfull');
    }
}
