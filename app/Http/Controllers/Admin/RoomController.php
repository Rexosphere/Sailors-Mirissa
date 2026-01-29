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
            // 'floor_coords' => 'required|string', // Removed
            // 'floor_name' => 'required|string', // Auto-generated
            'room_number' => 'required|integer',
            'room_name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:5120',
            'order' => 'required|integer|min:0',
        ]);

        // Handle image upload
        $image = $request->file('image');
        $imageName = time() . '_room_' . $validated['room_number'] . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/rooms'), $imageName);
        
        // Map floor_id to floor_name
        $floorNames = [
            'ground' => 'Ground Floor',
            'first' => 'First Floor',
            'second' => 'Second Floor',
            'third' => 'Third Floor',
        ];
        $floorName = $floorNames[$validated['floor_id']] ?? ucfirst($validated['floor_id']) . ' Floor';
        
        // Default empty coords
        $floorCoords = '';

        Room::create([
            'floor_id' => $validated['floor_id'],
            'floor_name' => $floorName,
            'floor_view' => $validated['floor_view'],
            'floor_coords' => $floorCoords,
            'room_number' => $validated['room_number'],
            'room_name' => $validated['room_name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'image_url' => '/images/rooms/' . $imageName,
            'order' => $validated['order'],
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
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
            'room_number' => 'required|integer',
            'room_name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'description' => 'required|string',
            'order' => 'required|integer|min:0',
        ];
        
        if ($request->hasFile('image')) {
            $rules['image'] = 'image|max:5120';
        }

        $validated = $request->validate($rules);

        // Map floor_id to floor_name if needed (though existing might be fine, let's update it to stay synced)
        $floorNames = [
            'ground' => 'Ground Floor',
            'first' => 'First Floor',
            'second' => 'Second Floor',
            'third' => 'Third Floor',
        ];
        $floorName = $floorNames[$validated['floor_id']] ?? ucfirst($validated['floor_id']) . ' Floor';

        $data = [
            'floor_id' => $validated['floor_id'],
            'floor_name' => $floorName,
            'floor_view' => $validated['floor_view'],
            'room_number' => $validated['room_number'],
            'room_name' => $validated['room_name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
            'order' => $validated['order'],
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_room_' . $validated['room_number'] . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/rooms'), $imageName);
            $data['image_url'] = '/images/rooms/' . $imageName;
        }

        $room->update($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }
}
