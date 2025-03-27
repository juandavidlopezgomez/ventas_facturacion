<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $activeClients = Client::where('status', true)->count();
        $clientsChange = 1; // Placeholder for percentage change

        return view('dashboard', compact('activeClients', 'clientsChange'));
    }
}