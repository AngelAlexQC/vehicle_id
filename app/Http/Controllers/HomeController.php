<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $record = Record::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
        $parkings = Parking::all();
        $parking_id = $request->parking_id;
        return view('home')->with(['record' => $record, 'parkings' => $parkings]);
    }
}
