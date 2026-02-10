<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MapPoint;
use Illuminate\Http\Request;

class MapPointController extends Controller
{
    /**
     * Store a newly created map point.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:5120',
            'icon_file' => 'nullable|image|max:2048', // Uploaded icon
            'center_x' => 'required|integer',
            'center_y' => 'required|integer',
            'coords' => 'required|string', // Will be auto-generated
        ]);

        // Handle image upload
        $image = $request->file('image');
        $imageName = time() . '_point_' . preg_replace('/[^a-z0-9_]/', '', str_replace(' ', '_', strtolower($validated['name']))) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/map-points'), $imageName);
        
        // Handle icon upload
        $iconHtml = null;
        if ($request->hasFile('icon_file')) {
            $icon = $request->file('icon_file');
            $iconName = time() . '_icon_' . preg_replace('/[^a-z0-9_]/', '', str_replace(' ', '_', strtolower($validated['name']))) . '.' . $icon->getClientOriginalExtension();
            $icon->move(public_path('images/icons'), $iconName);
            // Create the HTML for the icon as expected by the frontend
            $iconHtml = '<img src="/images/icons/' . $iconName . '" class="w-full h-full object-contain" alt="' . $validated['name'] . ' Icon">';
        }

        MapPoint::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'image_url' => '/images/map-points/' . $imageName,
            'coords' => $validated['coords'],
            'center_x' => $validated['center_x'],
            'center_y' => $validated['center_y'],
            'icon' => $iconHtml,
        ]);

        return redirect()->route('admin.map-points.index')->with('success', 'Map point created successfully.');
    }

    /**
     * Update the specified map point.
     */
    public function update(Request $request, $id)
    {
        $mapPoint = MapPoint::findOrFail($id);
        
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'center_x' => 'required|integer',
            'center_y' => 'required|integer',
            'coords' => 'required|string',
        ];
        
        if ($request->hasFile('image')) {
            $rules['image'] = 'image|max:5120';
        }

        if ($request->hasFile('icon_file')) {
            $rules['icon_file'] = 'image|max:2048';
        }
        
        $validated = $request->validate($rules);

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'center_x' => $validated['center_x'],
            'center_y' => $validated['center_y'],
            'coords' => $validated['coords'],
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_point_' . preg_replace('/[^a-z0-9_]/', '', str_replace(' ', '_', strtolower($validated['name']))) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/map-points'), $imageName);
            $data['image_url'] = '/images/map-points/' . $imageName;
        }

        // Handle icon upload
        if ($request->hasFile('icon_file')) {
            $icon = $request->file('icon_file');
            $iconName = time() . '_icon_' . preg_replace('/[^a-z0-9_]/', '', str_replace(' ', '_', strtolower($validated['name']))) . '.' . $icon->getClientOriginalExtension();
            $icon->move(public_path('images/icons'), $iconName);
            $data['icon'] = '<img src="/images/icons/' . $iconName . '" class="w-full h-full object-contain" alt="' . $validated['name'] . ' Icon">';
        }
        
        $mapPoint->update($data);

        return redirect()->route('admin.map-points.index')->with('success', 'Map point updated successfully.');
    }
}
