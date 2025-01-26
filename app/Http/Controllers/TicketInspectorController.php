<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\TicketInspector;
use Illuminate\Http\Request;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TicketInspectorStoreRequest;
use App\Http\Requests\TicketInspectorUpdateRequest;
use App\Repositories\TicketInspectorRepository;

class TicketInspectorController extends Controller
{
    protected $ticketInspectorRepository;

    public function __construct(TicketInspectorRepository $ticketInspectorRepository)
    {
        $this->ticketInspectorRepository = $ticketInspectorRepository;
    }

    // Ticket Inspector List Metho
    public function index()
    {
        return view('ticket-inspector.index');
    }

    // Ticket Inspector Datatable Method
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            return $this->ticketInspectorRepository->datatable($request);
        }
    }

    //Ticket Inspector Create Method
    public function create()
    {
        return view('ticket-inspector.create');
    }

    //Ticket Inspector Store Method
    public function store(TicketInspectorStoreRequest $request)
    {
        try {
            $this->ticketInspectorRepository->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return Redirect::route('ticket-inspector.index')->with('success', 'Ticket Inspector Create Successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    } // End Method

    //Ticket Inspector Edit Method
    public function edit($id)
    {
        $ticket_inspector = $this->ticketInspectorRepository->find($id);
        return view('ticket-inspector.edit', compact('ticket_inspector'));
    } // End Method

    //Ticket Inspector Update Method
    public function update(TicketInspectorUpdateRequest $request, $id)
    {
        try {
            $ticket_inspector = $this->ticketInspectorRepository->find($id);
            $this->ticketInspectorRepository->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $ticket_inspector->password,
            ], $id);

            return Redirect::route('ticket-inspector.index')->with('success', 'Ticket Inspector Updated Successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    } // End Method

    // Ticket Inspector Delete Method
    public function destroy($id)
    {
        try {
            $this->ticketInspectorRepository->delete($id);
            return ResponseService::success([], 'Successfully deleted');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
