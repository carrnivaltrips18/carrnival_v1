<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PopularTour;
use App\Models\Destination;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PopularTourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $popularTours = PopularTour::with('destination')
            ->where('package_name', 'LIKE', "%$search%")
            ->paginate(10);

        return view('popular_tours.index', compact('popularTours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $destinations = Destination::all();
        return view('popular_tours.create', compact('destinations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string|max:255',
            'duration' => 'required|string',
            'price' => 'required|numeric',
            'inclusion' => 'nullable|string',
            // 'package_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'destination_id' => 'required|exists:destinations,id', // Ensure destination_id exists
        ]);

        $tour = new PopularTour($request->all());

        if ($request->hasFile('package_image')) {
            $tour->package_image = $request->file('package_image')->store('popular_tours', 'public');
        }

        $tour->save();

        return redirect()->route('popular_tours.index')->with('success', 'Popular Tour created successfully.');
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
    public function edit(string $id)
    {
        $popularTour = PopularTour::findOrFail($id);
        $destinations = Destination::all();
        return view('popular_tours.edit', compact('popularTour', 'destinations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'package_name' => 'required|string|max:255',
            'duration' => 'required|string',
            'price' => 'required|numeric',
            'inclusion' => 'nullable|string',
            // 'package_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'destination_id' => 'required|exists:destinations,id', // Ensure destination_id exists
        ]);

        $tour = PopularTour::findOrFail($id);
        $tour->fill($request->all());

        if ($request->hasFile('package_image')) {
            // Delete old image if it exists
            if ($tour->package_image) {
                Storage::disk('public')->delete($tour->package_image);
            }
            $tour->package_image = $request->file('package_image')->store('popular_tours', 'public');
        }

        $tour->save();

        return redirect()->route('popular_tours.index')->with('success', 'Popular Tour updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tour = PopularTour::findOrFail($id);
        if ($tour->package_image) {
            Storage::disk('public')->delete($tour->package_image);
        }
        $tour->delete();
        return redirect()->route('popular_tours.index')->with('success', 'Popular Tour deleted successfully.');
    }

    public function exportCsvPopularTours()
    {
        // Get all popular tours with destination relationship
        $popularTours = PopularTour::with('destination')->get();
        
        // Create a new Spreadsheet instance
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set header
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Destination Name');
        $sheet->setCellValue('C1', 'Package Name');
        $sheet->setCellValue('D1', 'Duration');
        $sheet->setCellValue('E1', 'Price');
        $sheet->setCellValue('F1', 'Inclusion');
        $sheet->setCellValue('G1', 'Created At');
        $sheet->setCellValue('H1', 'Updated At');
        
        // Add popular tour data to the CSV
        $row = 2;
        $serial = 1;
        foreach ($popularTours as $tour) {
            $sheet->setCellValue('A' . $row, $serial);
            $sheet->setCellValue('B' . $row, $tour->destination->name); // Fetch destination name
            $sheet->setCellValue('C' . $row, $tour->package_name);
            $sheet->setCellValue('D' . $row, $tour->duration);
            $sheet->setCellValue('E' . $row, $tour->price);
            $sheet->setCellValue('F' . $row, $tour->inclusion);
            $sheet->setCellValue('G' . $row, $tour->created_at);
            $sheet->setCellValue('H' . $row, $tour->updated_at);

            $serial++;
            $row++;
        }
        
        // Export as CSV
        $writer = new Csv($spreadsheet);
        $fileName = 'popular_tours.csv';

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment;filename="' . $fileName . '"',
        ]);
    }

    public function importCsvPopularTours(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        // Load the uploaded CSV file
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathName());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Skip the header row (first row)
        foreach ($data as $key => $row) {
            if ($key === 0) {
                continue;
            }

            // Find the destination based on the name (assumes the second column is destination name)
            $destination = Destination::where('name', $row[1])->first();

            if ($destination) {
                // Create a new PopularTour entry
                PopularTour::create([
                    'destination_id' => $destination->id,
                    'package_name'   => $row[2],  // Third column is package name
                    'duration'       => $row[3],  // Fourth column is duration
                    'price'          => $row[4],  // Fifth column is price
                    'inclusion'      => $row[5],  // Sixth column is inclusion
                ]);
            }
        }

        return redirect()->back()->with('success', 'CSV file imported successfully.');
    }

    public function downloadSampleCsv()
    {
        $filePath = public_path('csv/sample_popular_tour.csv');

        if (file_exists($filePath)) {
            return response()->download($filePath, 'sample_popular_tour.csv');
        }

        return redirect()->back()->with('error', 'Sample CSV file not found.');
    }



}
