<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Destination;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinations = Destination::paginate(10);
        return view('destinations.index', compact('destinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('destinations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'banner' => 'nullable|image',
            'long_description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_content' => 'nullable|string',
        ]);

        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('banners');
        }

        Destination::create($validated);

        return redirect()->route('destinations.index')->with('success', 'Destination created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destination $destination)
    {
        return view('destinations.edit', compact('destination'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'banner' => 'nullable|image',
            'long_description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_content' => 'nullable|string',
        ]);
        
        if ($request->hasFile('banner')) {
            $validated['banner'] = $request->file('banner')->store('banners');
        }
        if ($request->hasFile('banner')) {
            Storage::disk('public')->delete($destination->banner);
            $imagePath = $request->file('banner')->store('banners', 'public');
            $validated['banner'] = $imagePath;
            // $destination->banner = $imagePath;
        }
      //  dd($validated);
        $destination->update($validated);

        return redirect()->route('destinations.index')->with('success', 'Destination updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        $destination->delete();
        return redirect()->route('destinations.index')->with('success', 'Destination deleted successfully.');
    }
}
