<?php

namespace App\Livewire\Admin;

use App\Models\Experience;
use Livewire\Component;
use Livewire\WithFileUploads;

class ExperienceForm extends Component
{
    use WithFileUploads;

    public ?Experience $experience = null;
    public $title = '';
    public $description = '';
    public $image_url = '';
    public $alt_text = '';
    public $badge = '';
    public $order = 0;
    public $image;

    public function mount($id = null)
    {
        if ($id) {
            $this->experience = Experience::findOrFail($id);
            $this->title = $this->experience->title;
            $this->description = $this->experience->description;
            $this->image_url = $this->experience->image_url;
            $this->alt_text = $this->experience->alt_text;
            $this->badge = $this->experience->badge ?? '';
            $this->order = $this->experience->order;
        }
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:5120', // 5MB max
        ]);
    }

    public function save()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'alt_text' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
        ];

        // Require image only for new experiences
        if (!$this->experience && !$this->image) {
            $rules['image'] = 'required|image|max:5120';
        } elseif ($this->image) {
            $rules['image'] = 'image|max:5120';
        }

        $this->validate($rules);

        // Handle image upload
        $imageUrl = $this->image_url;
        if ($this->image) {
            $filename = time() . '_' . preg_replace('/[^a-z0-9_]/', '', str_replace(' ', '_', strtolower($this->title))) . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('images/experiences', $filename, 'public_uploads');
            $imageUrl = '/images/experiences/' . $filename;
        }

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $imageUrl,
            'alt_text' => $this->alt_text,
            'badge' => $this->badge ?: null,
            'order' => $this->order,
        ];

        if ($this->experience) {
            $this->experience->update($data);
            session()->flash('success', 'Experience updated successfully.');
        } else {
            Experience::create($data);
            session()->flash('success', 'Experience created successfully.');
        }

        return redirect()->route('admin.experiences.index');
    }

    public function removeImage()
    {
        $this->image = null;
    }

    public function render()
    {
        return view('livewire.admin.experience-form')
            ->layout('components.layouts.admin-layout');
    }
}
