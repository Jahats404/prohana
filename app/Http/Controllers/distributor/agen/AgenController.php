<?php

namespace App\Http\Controllers\distributor\agen;

use App\Http\Controllers\Controller;
use App\Models\Agen;
use App\Models\Distributor;
use Illuminate\Http\Request;

class AgenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $domisiliDistributor = $user->distributor->domisili_distributor;
        $agen = Agen::where('domisili_agen', $domisiliDistributor)->get();
        
        return view('distributor.agen.index', compact('agen'));
    }
}