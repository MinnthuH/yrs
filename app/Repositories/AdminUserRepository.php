<?php

namespace App\Repositories;

use App\Models\AdminUser;
use Carbon\Carbon;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminUserRepository implements BaseRepository

{

    protected $model;

    public function __construct()
    {
        $this->model = AdminUser::class;
    }

    public function find($id)
    {
        $adminUser = $this->model::find($id);

        return $adminUser;
    }

    public function create(array $data)
    {
        $adminUser = $this->model::create($data);
        return $adminUser;
    }

    public function update(array $data, $id)
    {
        $adminUser = $this->model::find($id);
        $adminUser->update($data);

        return $adminUser;
    }

    public function delete($id)
    {
        $adminUser = $this->model::find($id);
        $adminUser->delete();
    }


    public function datatable(Request $request)
    {
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
