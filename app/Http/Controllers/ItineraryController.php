<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PopularTour; // Import the PopularTour model
use App\Models\Itinerary; 

class ItineraryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $itineraries = Itinerary::with('popularTour')
            ->where('title', 'LIKE', "%$search%")
            ->paginate(10);

        return view('admin.itineraries.index', compact('itineraries'));
    }

    public function create()
    {
        $popularTours = PopularTour::all();
        return view('admin.itineraries.create', compact('popularTours'));
    }
    // public function show($id)
    // {
    //     // For testing, just return the itinerary as JSON
    //     return response()->json(Itinerary::findOrFail($id));
    // }

    public function show($id)
    {
        // Retrieve the itinerary by its ID
        $itinerary = Itinerary::findOrFail($id);

        // Return a view, or just a JSON response if you don't have a specific view
        return view('admin.itineraries.show', compact('itinerary'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:popular_tours,id',
            'day_no' => 'required|integer',
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Itinerary::create($request->all());
        return redirect()->route('admin.itineraries.index')->with('success', 'Itinerary created successfully.');
    }

    public function edit(Itinerary $itinerary)
    {
        $popularTours = PopularTour::all();
        return view('admin.itineraries.edit', compact('itinerary', 'popularTours'));
    }

    public function update(Request $request, Itinerary $itinerary)
    {
        $request->validate([
            'tour_id' => 'required|exists:popular_tours,id',
            'day_no' => 'required|integer',
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $itinerary->update($request->all());
        return redirect()->route('admin.itineraries.index')->with('success', 'Itinerary updated successfully.');
    }

    public function destroy(Itinerary $itinerary)
    {
        $itinerary->delete();
        return redirect()->route('admin.itineraries.index')->with('success', 'Itinerary deleted successfully.');
    }

    public function checkTitle(Request $request)
    {
        
        $tourId = $request->query('tour_id');
        $dayNo = $request->query('day_no');

        $itinerary = Itinerary::where('tour_id', $tourId)->where('day_no', $dayNo)->first();

        if ($itinerary) {
            return response()->json(['title' => $itinerary->title]);
        }

        return response()->json(['title' => null]);
    }

}
