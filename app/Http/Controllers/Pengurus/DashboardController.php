<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\Berita;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $beritaCount = Berita::count();
        $aspirasiCount = Aspirasi::count();
        $anggotaCount = Pendaftaran::where('status', 'Lulus Wawancara')->count();
        $userCount = User::count();
        $users = User::latest()->take(5)->get();

        return view('pengurus.dashboard', compact('beritaCount', 'aspirasiCount', 'anggotaCount', 'userCount', 'users'));
    }
}
