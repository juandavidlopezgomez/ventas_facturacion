<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClients = Client::count();
        $activeClients = Client::where('status', 1)->count();
        $newClients = Client::where('created_at', '>=', now()->subMonth())->count();

        return view('dashboard.index', compact('totalClients', 'activeClients', 'newClients'));
    }
}