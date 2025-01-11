<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\AdminUserStoreRequest;
use App\Http\Requests\AdminUserUpdateRequest;

class AdminUserController extends Controller
{
    // Admin User List Metho
    public function index()
    {
        return view('admin-user.index');
    }

    // Admin user Datatable Method
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $model = AdminUser::query();

            return DataTables::eloquent($model)
                ->editColumn('created_at', function ($admin_user) {
                    return Carbon::parse($admin_user->created_at)->format('Y-m-d H:i:s');
                })
                ->editColumn('updated_at', function ($admin_user) {
                    return Carbon::parse($admin_user->created_at)->format('Y-m-d H:i:s');
                })
                ->addColumn('action', function ($admin_user) {
                    return view('admin-user._action', compact('admin_user'));
                })
                ->addColumn('responsive-icon', function ($admin_user) {
                    return null;
                })
                ->toJson();
        }
    }

    //Admin user Create Method
    public function create()
    {
        return view('admin-user.create');
    }

    //Admin Store Method
    public function store(AdminUserStoreRequest $request)
    {
        try {
            AdminUser::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->passwrord),
            ]);
            return Redirect::route('admin-user.index')->with('success', 'Admin Create Successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    } // End Method

    //Admin user Edit Method
    public function edit(AdminUser $admin_user)
    {
        return view('admin-user.edit', compact('admin_user'));
    } // End Method

    //Admin Update Method
    public function update(AdminUser $admin_user, AdminUserUpdateRequest $request)
    {
        try {
            $admin_user->name = $request->name;
            $admin_user->email = $request->email;
            $admin_user->password = $request->password ? Hash::make($request->password) : $admin_user->password;
            $admin_user->update();

            return Redirect::route('admin-user.index')->with('success', 'Admin Updated Successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    } // End Method

    // Admin Delete Method
    public function destroy(AdminUser $admin_user)
    {
        try {
            $admin_user->delete();
            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
