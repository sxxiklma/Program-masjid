<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Jamaah;
use App\Models\Infaq;
use App\Models\Kajian;
use Yajra\DataTables\DataTables;

class GuestController extends Controller
{
    public function index()
    {
        $nextKajian = Kajian::where('start_time', '>', now())->orderBy('start_time')->first();
        $defaultCityId = 1638;
        $jadwalDefault = app('App\Http\Controllers\JadwalsholatController')->getJadwalSholat($defaultCityId);
        $recentJamaah = Jamaah::orderBy('id', 'desc')->take(5)->get();
        $totalInfaq = Jamaah::sum('nominal');
        $infaqs = Infaq::all(); // Pastikan ini sesuai dengan dropdown di welcome.blade.php

        return view('welcome', compact('nextKajian', 'jadwalDefault', 'recentJamaah', 'totalInfaq', 'infaqs'));
    }
    
    public function create()
    {
        $infaqs = Infaq::all();
        return view('infaq.create', compact('infaqs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nomor' => 'required|numeric',
            'infaq' => 'required',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'alamat' => 'required',
            'nominal' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('public/images');
        }

        // Karena guest tidak memiliki user_id, Anda mungkin menyimpan data berbeda.
        DB::table('jamaahs')->insert([
            'nama' => $request->nama,
            'nomor' => $request->nomor,
            'infaq_id' => $request->infaq,
            'file_path' => $filePath,
            'alamat' => $request->alamat,
            'nominal' => $request->nominal,
        ]);

        Alert::success('Added Successfully', 'Infaq Added Successfully.');
        return redirect()->route('welcome');
    }

}
