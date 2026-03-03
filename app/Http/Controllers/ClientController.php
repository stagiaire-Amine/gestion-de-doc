<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Services\ClientsApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    protected $api;

    public function __construct(ClientsApi $api)
    {
        $this->api = $api;
    }

    /**
     * Display a listing of clients.
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        $apiError = null;
        $clients = [];

        try {
            $clients = $this->api->index($q);
        } catch (\Exception $e) {
            Log::error('ClientController@index: ' . $e->getMessage());
            $apiError = "The Clients API is currently unavailable. Please try again later.";
        }

        return view('clients.index', compact('clients', 'q', 'apiError'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created client.
     */
    public function store(StoreClientRequest $request)
    {
        try {
            $this->api->store($request->validated());

            return redirect()->route('clients.index')
                ->with('success', 'Client created successfully.');
        } catch (\Exception $e) {
            Log::error('ClientController@store: ' . $e->getMessage());

            return back()->withInput()->withErrors([
                'api' => 'API error: ' . $e->getMessage()
            ]);
        }
    }
}
