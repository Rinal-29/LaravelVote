<?php

namespace App\Http\Controllers;

use App\Models\Kandidats;
use App\Models\Locations;
use App\Models\LocationsGallery;
use App\Models\Pemilihs;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $locations = Locations::all();
        $gallery = LocationsGallery::all();
        $users = User::all();
        $kandidat = Kandidats::all();
        $pemilih = Pemilihs::all();
        return view('pages.dashboard.index', compact(['locations', 'gallery', 'users', 'kandidat', 'pemilih']));
    }
}
