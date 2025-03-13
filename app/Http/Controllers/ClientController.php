<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client; // Asegúrate de importar el modelo Client

class ClientController extends Controller
{
    /**
     * Muestra una lista de clientes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $clients = Client::all(); // Obtén todos los clientes
        return view('clients.index', ['clients' => $clients]); // Pasa los clientes a la vista
    }
}