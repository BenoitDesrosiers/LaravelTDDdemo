<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Personne;


class PersonnesController extends Controller
{
    public function index()
    {
    	
    	$personnes = Personne::all();
    	return view('personnes/index', compact('personnes'));
    }
}
