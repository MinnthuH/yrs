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
use App\Repositories\AdminUserRepository;

class AdminUserController extends Controller
{
    protected $adminUserRepository;

    public function __construct(AdminUserRepository $adminUserRepository)
    {
        $this->adminUserRepository = $adminUserRepository;
    }

    // Admin User List Metho
    public function index()
    {
        return view('admin-user.index');
    }

    // Admin user Datatable Method
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->adminUserRepository->datatable($request);
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
            $this->adminUserRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return Redirect::route('admin-user.index')->with('success', 'Admin Create Successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    } // End Method

    //Admin user Edit Method
    public function edit($id)
    {
        $admin_user = $this->adminUserRepository->find($id);
        return view('admin-user.edit', compact('admin_user'));
    } // End Method

    //Admin Update Method
    public function update(AdminUserUpdateRequest $request, $id)
    {
        try {
            $admin_user = $this->adminUserRepository->find($id);
            $this->adminUserRepository->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $admin_user->password,
            ], $id);

            return Redirect::route('admin-user.index')->with('success', 'Admin Updated Successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    } // End Method

    // Admin Delete Method
    public function destroy($id)
    {
        try {
            $this->adminUserRepository->delete($id);
            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
