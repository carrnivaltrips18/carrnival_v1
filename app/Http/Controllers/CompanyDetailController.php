<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyDetail;
use Illuminate\Support\Facades\Storage;


class CompanyDetailController extends Controller
{
    public function index()
    {
        $company = CompanyDetail::first();
        return view('admin.company.index', compact('company'));
    }

    public function edit()
    {
        $company = CompanyDetail::first();
        return view('admin.company.edit', compact('company'));
    }


    public function update(Request $request)
    {
       // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'website' => 'required|url',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
        ]);
       
        $company = CompanyDetail::first();

        if ($request->hasFile('logo')) {
            Storage::disk('public')->delete($company->logo);
            $imagePath = $request->file('logo')->store('images', 'public');
            $company->logo = $imagePath;
        }

         // Handle favicon upload if provided
         if ($request->hasFile('fav_icon')) {
            Storage::disk('public')->delete($company->fav_icon);
            $favIconPath = $request->file('fav_icon')->store('images', 'public');
            $company->fav_icon = $favIconPath;
        }

        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;
        $company->phone = $request->phone;
        $company->address = $request->address;
        $company->description = $request->description;
        $company->facebook = $request->facebook;
        $company->twitter = $request->twitter;
        $company->instagram = $request->instagram;
        $company->save();

        return redirect()->route('admin.company.index')
            ->with('success', 'Image updated successfully.');
    }
    

    public function destroy($id)
    {
        // Find the company detail by id
        $companyDetail = CompanyDetail::findOrFail($id);
        
        // Check if a logo exists and delete it from the system
        if ($companyDetail->logo) {
            $logoPath = public_path('public/images/' . $companyDetail->logo);
            if (file_exists($logoPath)) {
                unlink($logoPath); // Delete the logo file from the system
            }
        }

        // Delete the company detail from the database
        $companyDetail->delete();

        // Redirect with success message
        return redirect()->route('company.details.index')
                        ->with('success', 'Company details and logo deleted successfully.');
    }


}
