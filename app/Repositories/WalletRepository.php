<?php

namespace App\Repositories;

use Carbon\Carbon;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Contracts\BaseRepository;

class WalletRepository implements BaseRepository

{

    protected $model;

    public function __construct()
    {
        $this->model = Wallet::class;
    }

    public function find($id)
    {
        $wallet = $this->model::find($id);

        return $wallet;
    }

    public function create(array $data)
    {
        $wallet = $this->model::create($data);
        return $wallet;
    }

    public function firstOrCreate(array $data1, array $data2)
    {
        $this->model::firstOrCreate($data1, $data2);
      
    }

    public function update(array $data, $id)
    {
        $wallet = $this->model::find($id);
        $wallet->update($data);

        return $wallet;
    }

    public function delete($id)
    {
        $wallet = $this->model::find($id);
        $wallet->delete();
    }


    public function datatable(Request $request)
    {
        $model = Wallet::query();

        return DataTables::eloquent($model)
            ->addColumn('user_name', function ($wallet) {
                return ($wallet->user->name ?? '-'). '('.($wallet->user->email ?? '-').')';
            })
            ->editColumn('amount', function ($wallet) {
                return number_format($wallet->amount) ?? '-';
            })
            ->editColumn('created_at', function ($wallet) {
                return Carbon::parse($wallet->created_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($wallet) {
                return Carbon::parse($wallet->created_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('responsive-icon', function ($wallet) {
                return null;
            })
            ->toJson();
    }
}
