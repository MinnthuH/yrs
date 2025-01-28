<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

use App\Repositories\WalletRepository;

class WalletController extends Controller
{
    protected $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    //  Wallet List Method
    public function index()
    {
        return view('wallet.index');
    }

    //  Wallet Datatable Method
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->walletRepository->datatable($request);
        }
    }

  
}
