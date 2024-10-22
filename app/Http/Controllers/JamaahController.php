<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Jamaah;
use App\Models\Infaq;
use App\Models\Kajian;
use Yajra\DataTables\DataTables;
use RealRashid\SweetAlert\Facades\Alert;


class JamaahController extends Controller
{
    public function welcome(Request $request)
    {
        $search = $request->query('search');

        // Fetch Jamaahs with joined Infaqs
        $query = DB::table('jamaahs')
            ->join('infaqs', 'jamaahs.infaq_id', '=', 'infaqs.id')
            ->select('jamaahs.*', 'infaqs.name as infaq_name');

        if ($search) {
            $query->where('jamaahs.nama', 'like', '%' . $search . '%');
        }

        $jamaahs = $query->get();

        // Fetch Infaqs
        $infaqs = Infaq::all();

        // Fetch Kajian data
        $nextKajian = Kajian::where('start_time', '>', now())->orderBy('start_time')->first();

        // Example of fetching prayer schedule data
        $defaultCityId = 1638;
        $jadwalDefault = app('App\Http\Controllers\JadwalsholatController')->getJadwalSholat($defaultCityId);

        return view('welcome', compact('jamaahs', 'infaqs', 'jadwalDefault', 'search', 'nextKajian'));
    }


    public function index(Request $request, JadwalsholatController $jadwalsholatController)
    {
        // This method is for the main view
        $defaultCityId = 1638; // ID kota Surabaya
        $jadwalDefault = $jadwalsholatController->getJadwalSholat($defaultCityId);

        return view('home', compact('jadwalDefault'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('jamaahs')
                ->join('infaqs', 'jamaahs.infaq_id', '=', 'infaqs.id')
                ->select('jamaahs.*', 'infaqs.name as infaq_name');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('infaq.show', $row->id).'" class="btn btn-outline-dark btn-sm me-2" title="View"><i class="bi bi-person-lines-fill"></i></a>';
                    $actionBtn .= '<a href="'.route('infaq.edit', $row->id).'" class="btn btn-outline-dark btn-sm me-2" title="Edit"><i class="bi bi-pencil-square"></i></a>';
                    $actionBtn .= '<form action="'.route('infaq.destroy', $row->id).'" method="POST" style="display:inline;">'.csrf_field().method_field('DELETE').'<button type="submit" class="btn btn-outline-dark btn-sm" title="Delete"><i class="bi bi-trash"></i></button></form>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, JadwalsholatController $jadwalsholatController)
    {
        $searchCity = $request->query('search_city');

        // RAW SQL Query for fetching infaqs
        $infaqsQuery = DB::table('infaqs');

        // Apply search filter if search term is provided
        if ($searchCity) {
            $infaqsQuery->where('name', 'like', '%' . $searchCity . '%');
        }

        $infaqs = $infaqsQuery->get();

        // Example of fetching prayer schedule data
        $defaultCityId = 1638; // ID kota Surabaya
        $jadwalDefault = $jadwalsholatController->getJadwalSholat($defaultCityId);

        $nextKajian = Kajian::where('start_time', '>', now())->orderBy('start_time')->first();

        return view('welcome', compact('infaqs', 'jadwalDefault', 'searchCity','nextKajian'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'nomor' => 'required|string|max:255',
        'alamat' => 'nullable|string|max:255',
        'nominal' => 'required|numeric',
        'infaq' => 'required|exists:infaq_categories,id', // Validasi untuk infaq
        'file' => 'nullable|file|mimes:jpg,png,pdf|max:2048', // Validasi untuk file
    ]);

    $input = $request->all();

    if ($file = $request->file('file')) {
        $destinationPath = 'images/';
        $fileName = date('YmdHis') . "." . $file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);
        $input['file_path'] = $destinationPath . $fileName; // Save the file path in the database
    }

    Jamaah::create($input);

    return redirect()->back()->with('success', 'Infaq berhasil disimpan');
}



    public function show(string $id)
    {
        // ELOQUENT
        $jamaahs = Jamaah::find($id);
        return view('infaq.show', compact('jamaahs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Find the Jamaah record by ID
        $jamaah = Jamaah::findOrFail($id);

        // Get all infaq categories for the dropdown
        $infaqs = Infaq::all();

        // Pass the data to the edit view
        return view('infaq.edit', compact('jamaah', 'infaqs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'nomor' => 'required|string|max:15',
        'infaq_id' => 'required|exists:infaq_categories,id',
        'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $jamaah = Jamaah::findOrFail($id);
    $jamaah->nama = $request->nama;
    $jamaah->nomor = $request->nomor;
    $jamaah->infaq_id = $request->infaq_id;

    if ($request->hasFile('file')) {
        if ($jamaah->file_path) {
            \Storage::delete($jamaah->file_path); // Delete old file if exists
        }

        $destinationPath = 'images/';
        $fileName = date('YmdHis') . "." . $request->file('file')->getClientOriginalExtension();
        $request->file('file')->move($destinationPath, $fileName);
        $jamaah->file_path = $destinationPath . $fileName; // Save new file path
    }

    $jamaah->save();

    return redirect()->route('homeuser.index')->with('success', 'Infaq updated successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // ELOQUENT: Find the record by ID
        $jamaah = Jamaah::find($id);

        // Check if the record exists
        if ($jamaah) {
            $jamaah->delete(); // Delete the record if found
            Alert::success('Deleted Successfully', 'Infaq Deleted Successfully.');
        } else {
            // Handle the case where the record is not found
            Alert::error('Deletion Failed', 'Infaq not found.');
        }

        return redirect()->route('home'); // Redirect back to the desired route
    }
}
