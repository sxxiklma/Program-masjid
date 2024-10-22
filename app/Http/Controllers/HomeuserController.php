<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Jamaah;
use App\Models\Infaq;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class HomeuserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        Log::info('Authenticated User ID: ' . $userId);

        $jamaahs = DB::table('jamaahs')
            ->join('infaqs', 'jamaahs.infaq_id', '=', 'infaqs.id')
            ->select('jamaahs.*', 'infaqs.name as infaq_name')
            ->where('jamaahs.user_id', $userId)
            ->get();

        return view('homeuser', compact('jamaahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $infaqs = Infaq::all();
        return view('infaq.create', compact('infaqs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Store method called');

        $messages = [
            'required' => ':Attribute harus diisi.',
            'numeric' => 'Isi :attribute dengan angka.',
            'file' => 'Upload bukti transfermu.',
            'mimes' => 'Format file harus jpg, jpeg, png, atau pdf.',
        ];

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nomor' => 'required|numeric',
            'infaq' => 'required',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'alamat' => 'required', // Menambahkan validasi untuk alamat
            'nominal' => 'required|numeric', // Menambahkan validasi untuk nominal
        ], $messages);

        if ($validator->fails()) {
            Log::info('Validation failed: ', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
        }

        $userId = Auth::id(); // get id yang masuk skrg
        Log::info('User ID for storing: ' . $userId);
        Log::info('Request data: ', $request->all());
        Log::info('File path: ' . $filePath);

        try {
            Log::info('Inserting data for user');

            DB::table('jamaahs')->insert([
                'nama' => $request->nama,
                'nomor' => $request->nomor,
                'infaq_id' => $request->infaq,
                'file_path' => $filePath,
                'user_id' => $userId,
                'alamat' => $request->alamat, // Menambahkan alamat
                'nominal' => $request->nominal, // Menambahkan nominal
            ]);
            Log::info('Data inserted for user');
        } catch (\Exception $e) {
            Log::error('Error inserting data: ' . $e->getMessage());
        }

        Log::info('Store method completed');

        Alert::success('Added Successfully', 'Infaq Added Successfully.');

        // Menggunakan redirectToHome() untuk redirect sesuai peran
        return $this->redirectToHome();
    }

    /**
     * Redirect to the appropriate home page based on user role.
     */
    public function redirectToHome()
    {
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('home'); // Redirect ke halaman admin
        } elseif (Auth::user()->hasRole('user')) {
            return redirect()->route('homeuser'); // Redirect ke halaman user
        } else {
            return redirect()->route('welcome'); // Redirect ke halaman default jika bukan admin/user
        }
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
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $jamaah = Jamaah::findOrFail($id);

        $jamaah->nama = $request->nama;
        $jamaah->nomor = $request->nomor;
        $jamaah->infaq_id = $request->infaq_id;

        if ($request->hasFile('file_path')) {
            if ($jamaah->file_path) {
                Storage::delete($jamaah->file_path);
            }

            $file = $request->file('file_path')->store('infaq_files');
            $jamaah->file_path = $file;
        }

        $jamaah->save();

        return redirect()->route('homeuser');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userId = Auth::id();
        $jamaah = Jamaah::where('user_id', $userId)->findOrFail($id);
        $jamaah->delete();

        Alert::success('Deleted Successfully', 'Infaq Deleted Successfully.');

        return redirect()->route('homeuser');
    }
}
