<?php

namespace App\Repositories;

use App\Models\TicketInspector;
use Carbon\Carbon;
use App\Repositories\Contracts\BaseRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TicketInspectorRepository implements BaseRepository

{

    protected $model;

    public function __construct()
    {
        $this->model = TicketInspector::class;
    }

    public function find($id)
    {
        $ticket_inspector = $this->model::find($id);

        return $ticket_inspector;
    }

    public function create(array $data)
    {
        $ticket_inspector = $this->model::create($data);
        return $ticket_inspector;
    }

    public function update(array $data, $id)
    {
        $ticket_inspector = $this->model::find($id);
        $ticket_inspector->update($data);

        return $ticket_inspector;
    }

    public function delete($id)
    {
        $ticket_inspector = $this->model::find($id);
        $ticket_inspector->delete();
    }


    public function datatable(Request $request)
    {
        $model = TicketInspector::query();

        return DataTables::eloquent($model)
            ->editColumn('email_verified_at', function ($ticket_inspector) {
                return $ticket_inspector->email_verified_at ? Carbon::parse($ticket_inspector->email_verified_at)->format('Y-m-d H:i:s') : '-';
            })
            ->editColumn('created_at', function ($ticket_inspector) {
                return Carbon::parse($ticket_inspector->created_at)->format('Y-m-d H:i:s');
            })
            ->editColumn('updated_at', function ($ticket_inspector) {
                return Carbon::parse($ticket_inspector->created_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($ticket_inspector) {
                return view('ticket-inspector._action', compact('ticket_inspector'));
            })
            ->addColumn('responsive-icon', function ($ticket_inspector) {
                return null;
            })
            ->toJson();
    }
}
