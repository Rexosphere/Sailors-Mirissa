<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Store a newly created room.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'floor_id' => 'required|string',
            'floor_view' => 'required|string|max:255',
            'room_type' => 'required|string|in:double,twin',
            'price' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'required|image|max:5120',
            'order' => 'required|integer|min:0',
        ]);

        // Handle multiple image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '_' . $validated['floor_id'] . '_' . $validated['room_type'] . '.' . $image->getClientOriginalExtension();
                $image->storeAs('images/rooms', $imageName, 'public');
                $imagePaths[] = '/storage/images/rooms/' . $imageName;
            }
        }
        
        Room::create([
            'floor_id' => $validated['floor_id'],
            'floor_view' => $validated['floor_view'],
            'room_type' => $validated['room_type'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'facilities' => $request->input('facilities', []),
            'image_url' => $imagePaths[0] ?? '',
            'images' => $imagePaths,
            'order' => $validated['order'],
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room category created successfully.');
    }

    /**
     * Update the specified room.
     */
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        
        $rules = [
            'floor_id' => 'required|string',
            'floor_view' => 'required|string|max:255',
            'room_type' => 'required|string|in:double,twin',
            'price' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'required|integer|min:0',
        ];
        
        if ($request->hasFile('images')) {
            $rules['images.*'] = 'image|max:5120';
        }

        $validated = $request->validate($rules);

        $data = [
            'floor_id' => $validated['floor_id'],
            'floor_view' => $validated['floor_view'],
            'room_type' => $validated['room_type'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'facilities' => $request->input('facilities', []),
            'order' => $validated['order'],
        ];

        // Handle removed images
        $currentImages = $room->images ?? [];
        if ($request->has('removed_images')) {
            $removedImages = json_decode($request->input('removed_images'), true) ?? [];
            $currentImages = array_values(array_diff($currentImages, $removedImages));
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '_' . $validated['floor_id'] . '_' . $validated['room_type'] . '.' . $image->getClientOriginalExtension();
                $image->storeAs('images/rooms', $imageName, 'public');
                $currentImages[] = '/storage/images/rooms/' . $imageName;
            }
        }

        // Update images array
        if (!empty($currentImages)) {
            $data['images'] = $currentImages;
            $data['image_url'] = $currentImages[0]; // Keep first image as primary
        }

        $room->update($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }
}
