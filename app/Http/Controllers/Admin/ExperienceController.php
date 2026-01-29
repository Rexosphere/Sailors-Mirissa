<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    /**
     * Store a newly created experience.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:5120', // 5MB max
            'alt_text' => 'required|string|max:255',
            'badge' => 'nullable|string|max:255',
            'icon' => 'nullable|string',
            'order' => 'required|integer|min:0',
        ]);

        // Handle image upload
        $image = $request->file('image');
        $filename = time() . '_' . preg_replace('/[^a-z0-9_]/', '', str_replace(' ', '_', strtolower($validated['title']))) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/experiences'), $filename);
        
        Experience::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_url' => '/images/experiences/' . $filename,
            'alt_text' => $validated['alt_text'],
            'badge' => $validated['badge'] ?? null,
            'icon' => $validated['icon'] ?? null,
            'order' => $validated['order'],
        ]);

        return redirect()->route('admin.experiences.index')->with('success', 'Experience created successfully.');
    }

    /**
     * Update the specified experience.
     */
    public function update(Request $request, $id)
    {
        $experience = Experience::findOrFail($id);
        
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'alt_text' => 'required|string|max:255',
            'badge' => 'nullable|string|max:255',
            'icon' => 'nullable|string',
            'order' => 'required|integer|min:0',
        ];
        
        // Image is optional on update
        if ($request->hasFile('image')) {
            $rules['image'] = 'image|max:5120';
        }
        
        $validated = $request->validate($rules);

        // Handle image upload if provided
        $imageUrl = $experience->image_url;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . preg_replace('/[^a-z0-9_]/', '', str_replace(' ', '_', strtolower($validated['title']))) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/experiences'), $filename);
            $imageUrl = '/images/experiences/' . $filename;
        }
        
        $experience->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_url' => $imageUrl,
            'alt_text' => $validated['alt_text'],
            'badge' => $validated['badge'] ?? null,
            'icon' => $validated['icon'] ?? null,
            'order' => $validated['order'],
        ]);

        return redirect()->route('admin.experiences.index')->with('success', 'Experience updated successfully.');
    }
}
