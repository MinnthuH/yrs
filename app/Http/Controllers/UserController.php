<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    //  User List Metho
    public function index()
    {
        return view('user.index');
    }

    //  user Datatable Method
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->userRepository->datatable($request);
        }
    }

    // user Create Method
    public function create()
    {
        return view('user.create');
    }

    // Store Method
    public function store(UserStoreRequest $request)
    {
        try {
            $this->userRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return Redirect::route('user.index')->with('success', 'User Create Successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    } // End Method

    // user Edit Method
    public function edit($id)
    {
        $user = $this->userRepository->find($id);
        return view('user.edit', compact('user'));
    } // End Method

    // Update Method
    public function update(UserUpdateRequest $request, $id)
    {
        try {
            $user = $this->userRepository->find($id);
            $this->userRepository->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ], $id);

            return Redirect::route('user.index')->with('success', 'User Updated Successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    } // End Method

    //  Delete Method
    public function destroy($id)
    {
        try {
            $this->userRepository->delete($id);
            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
