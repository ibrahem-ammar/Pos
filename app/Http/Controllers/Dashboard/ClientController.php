<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index()
    {
        $clients = Client::paginate();
        return view('dashboard.clients.index',compact('clients'));
    }

    public function create()
    {
        return view('dashboard.clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        Client::create($request->all());

        return redirect()->route('dashboard.clients.index')->with([
            'success' => __('site.created_seccessfully'),
        ]);
    }

    public function edit(Client $client)
    {
        return view('dashboard.clients.edit',compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $client->update($request->all());

        return redirect()->route('dashboard.clients.index')->with([
            'success' => __('site.updated_seccessfully'),
        ]);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('dashboard.clients.index')->with([
            'success' => __('site.deleted_seccessfully'),
        ]);
    }
}
