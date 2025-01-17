<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserRepository implements BaseRepository

{

    protected $model;

    public function __construct()
    {
        $this->model = User::class;
    }

    public function find($id)
    {
        $user = $this->model::find($id);

        return $user;
    }

    public function create(array $data)
    {
        $user = $this->model::create($data);
        return $user;
    }

    public function update(array $data, $id)
    {
        $user = $this->model::find($id);
        $user->update($data);

        return $user;
    }

    public function delete($id)
    {
        $user = $this->model::find($id);
        $user->delete();
    }


    public function datatable(Request $request)
    {
        $model = User::query();

        return DataTables::eloquent($model)
            ->editColumn('email_verified_at', function ($user) {
                return $user->email_verified_at ? Carbon::parse($user->email_verified_at)->format('Y-m-d H:i:s') : '-';
            })
            ->editColumn('created_at', function ($user) {
                return Carbon::parse($user->created_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($user) {
                return Carbon::parse($user->created_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($user) {
                return view('user._action', compact('user'));
            })
            ->addColumn('responsive-icon', function ($user) {
                return null;
            })
            ->toJson();
    }
}
