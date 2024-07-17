<?php

namespace App\Http\Controllers\agen\distributor;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index(){
        $distributor = Distributor::all();
        return view('agen.distributor.index', compact('distributor'));
    }
    public function show(){

    }
}
