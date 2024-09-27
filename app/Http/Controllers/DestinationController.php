<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Destination;
use Illuminate\Support\Facades\Storage;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DestinationController extends Controller
{
    /**
     * Display the list of destinations with search functionality
     */
    public function index(Request $request)
    {
        // $destinations = Destination::paginate(10);
        // Get the search query from the request
        $search = $request->input('search');

        // Modify the query to include search functionality
        $destinations = Destination::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('title', 'like', '%' . $search . '%');
        })->paginate(10); // Paginate results
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

    public function exportCsvDestination()
    {  
        // Get all destinations
        $destinations = Destination::all();
       
        // Create a new Spreadsheet instance
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Title');
        $sheet->setCellValue('D1', 'Banner');
        $sheet->setCellValue('E1', 'Long Description');
        $sheet->setCellValue('F1', 'Meta Title');
        $sheet->setCellValue('G1', 'Meta Content');
        $sheet->setCellValue('H1', 'Created At');
        $sheet->setCellValue('I1', 'Updated At');

        // Add destination data to the CSV
        $row = 2;
        $serial = 1;
        foreach ($destinations as $destination) {
            $sheet->setCellValue('A' . $row, $serial);
            $sheet->setCellValue('B' . $row, $destination->name);
            $sheet->setCellValue('C' . $row, $destination->title);
            $sheet->setCellValue('D' . $row, $destination->banner);
            $sheet->setCellValue('E' . $row, $destination->long_description);
            $sheet->setCellValue('F' . $row, $destination->meta_title);
            $sheet->setCellValue('G' . $row, $destination->meta_content);
            $sheet->setCellValue('H' . $row, $destination->created_at);
            $sheet->setCellValue('I' . $row, $destination->updated_at);

            $serial++;
            $row++;
        }

        // Export as CSV
        $writer = new Csv($spreadsheet);
        $fileName = 'destinations.csv';

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment;filename="' . $fileName . '"',
        ]);
    }

    public function uploadCsvDestination(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathName());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Skip the header row (first row)
        foreach ($data as $key => $row) {
            if ($key === 0) {
                continue;
            }

            // Check if an image (banner) is provided and handle it
            $banner = $row[2]; // Assuming the 3rd column is banner (file path or URL)
            if ($banner) {
                $bannerPath = 'banners/' . $banner;
            }

            // Create or update the destination record
            Destination::updateOrCreate(
                ['name' => $row[0]], // Assuming first column is 'name'
                [
                    'title' => $row[1], // Assuming second column is 'title'
                    'banner' => $bannerPath, // Banner path from CSV (or null)
                    'long_description' => $row[3], // Assuming fourth column is 'long_description'
                    'meta_title' => $row[4], // Assuming fifth column is 'meta_title'
                    'meta_content' => $row[5], // Assuming sixth column is 'meta_content'
                ]
            );
        }

        return redirect()->back()->with('success', 'CSV file imported successfully.');
    }


    public function toggleStatus($id)
    {
        $destination = Destination::findOrFail($id);

        // Toggle the status: if it is 1 (active), set it to 0 (inactive) and vice versa.
        $destination->status = $destination->status === '1' ? '0' : '1';
        $destination->save();

        return redirect()->route('destinations.index')->with('success', 'Destination status updated successfully!');
    }

    public function downloadSampleCsv()
    {
        $filePath = public_path('csv/sample_destination.csv');

        if (file_exists($filePath)) {
            return response()->download($filePath, 'sample_destination.csv');
        }

        return redirect()->back()->with('error', 'Sample CSV file not found.');
    }

}
