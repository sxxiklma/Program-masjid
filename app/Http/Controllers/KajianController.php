<?php

namespace App\Http\Controllers;

use App\Models\Kajian;
use App\Models\Ustadz;
use App\Models\JenisKajian;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KajianController extends Controller
{
    public function index()
    {
        $kajians = Kajian::with('ustadz', 'jeniskajian')->get();
        return view('kajians.index', compact('kajians'));
    }

    public function create()
    {
        $ustadzList = Ustadz::pluck('name', 'id')->toArray();
        $jeniskajianList = JenisKajian::pluck('name', 'id')->toArray();
        return view('kajians.create', compact('ustadzList', 'jeniskajianList'));
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'youtube_link' => 'required|url',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'start_time' => 'nullable|date',
        'ustadz_id' => 'required|exists:ustadzs,id',
        'jeniskajian_id' => 'required|exists:jeniskajians,id',
    ]);

    $input = $request->all();

    if ($image = $request->file('image')) {
        $destinationPath = 'images/';
        $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $profileImage);
        $input['image'] = "$profileImage";
    }

    Kajian::create($input);

    Alert::success('Success', 'Kajian created successfully.');

    return redirect()->route('kajians.index');
}

    public function show($id)
    {
        $kajian = Kajian::with('ustadz', 'jeniskajian')->findOrFail($id);
        return view('kajians.show', compact('kajian'));
    }

    public function edit(Kajian $kajian)
    {
        $ustadzList = Ustadz::pluck('name', 'id')->toArray();
        $jeniskajianList = JenisKajian::pluck('name', 'id')->toArray();
        return view('kajians.edit', compact('kajian', 'ustadzList', 'jeniskajianList'));
    }

    public function update(Request $request, Kajian $kajian)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_link' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_time' => 'nullable|date',
            'ustadz_id' => 'required|exists:ustadzs,id',
            'jeniskajian_id' => 'required|exists:jeniskajians,id',
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";

            // Delete old image
            if ($kajian->image && file_exists($destinationPath . $kajian->image)) {
                unlink($destinationPath . $kajian->image);
            }
        } else {
            unset($input['image']);
        }

        $kajian->update($input);

        Alert::success('Success', 'Kajian updated successfully.');

        return redirect()->route('kajians.index');
    }


    public function destroy(Kajian $kajian)
    {
        $kajian->delete();

        Alert::success('Success', 'Kajian deleted successfully.');

        return redirect()->route('kajians.index');
    }
}
