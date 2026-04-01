<?php

namespace App\Http\Controllers;

use App\Models\Eventimage;
use App\Models\Eventpage;
use App\Models\Restaurant;
use App\Models\Restoimage;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    public function eventsPage()
    {
        $data = Eventpage::first();
        $images = collect();
        $totalImages = 0;

        if ($data) {
            $data->load('images');
            $images = $data->images ?? collect();
            $totalImages = $images->count();
        } else {
            $data = Eventpage::create([
                'title' => 'Meetings & Events',
                'description' => 'Host your meetings and events with us.',
                'details' => '',
            ]);
            $data = Eventpage::first();
        }

        return view('admin.pages.events', [
            'data' => $data,
            'images' => $images,
            'totalImages' => $totalImages,
        ]);
    }

    public function saveEvent(Request $request)
    {
        $data = Eventpage::firstOrFail();
        $data->title = $request->input('title');
        $data->description = $request->input('description');
        $data->details = $request->input('details');

        $data->save();

        return redirect()->back()->with('success', 'Page has been updated successfully');
    }

    public function addEventImage(Request $request)
    {
        $request->validate([
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'eventpage_id' => 'required|exists:eventpages,id',
        ]);

        if (! $request->hasFile('image')) {
            return redirect()->back()->with('error', 'No images were uploaded.');
        }

        $maxOrder = (int) Eventimage::where('eventpage_id', $request->eventpage_id)->max('sort_order');

        foreach ($request->file('image') as $image) {
            $path = $image->store('public/images/events');
            $fileName = str_replace('public/images/events/', '', $path);

            $maxOrder++;
            Eventimage::create([
                'image' => $fileName,
                'eventpage_id' => $request->eventpage_id,
                'user_id' => $request->user()?->id,
                'sort_order' => $maxOrder,
            ]);
        }

        return redirect()->back()->with('success', 'Images uploaded successfully!');
    }

    public function updateEventImage(Request $request, $id)
    {
        $request->validate([
            'caption' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        $row = Eventimage::findOrFail($id);

        if ($request->exists('caption')) {
            $row->caption = $request->input('caption');
        }

        if ($request->hasFile('image')) {
            $diskPath = 'images/events/'.$row->image;
            if (Storage::disk('public')->exists($diskPath)) {
                Storage::disk('public')->delete($diskPath);
            }
            $path = $request->file('image')->store('public/images/events');
            $fileName = str_replace('public/images/events/', '', $path);
            $row->image = $fileName;
        }

        $row->save();

        return redirect()->back()->with('success', 'Image updated.');
    }

    public function reorderEventImage(Request $request, $id)
    {
        $request->validate(['direction' => 'required|in:up,down']);

        $img = Eventimage::findOrFail($id);
        $rows = Eventimage::where('eventpage_id', $img->eventpage_id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $idx = $rows->search(fn ($r) => (int) $r->id === (int) $img->id);
        if ($idx === false) {
            return redirect()->back();
        }

        $swapIdx = $request->input('direction') === 'up' ? $idx - 1 : $idx + 1;
        if ($swapIdx < 0 || $swapIdx >= $rows->count()) {
            return redirect()->back();
        }

        $a = $rows[$idx];
        $b = $rows[$swapIdx];
        $tmp = $a->sort_order;
        $a->sort_order = $b->sort_order;
        $b->sort_order = $tmp;
        $a->save();
        $b->save();

        return redirect()->back()->with('success', 'Order updated.');
    }

    public function deleteEventImage($id)
    {
        $image = Eventimage::findOrFail($id);
        $diskPath = 'images/events/'.$image->image;
        if (Storage::disk('public')->exists($diskPath)) {
            Storage::disk('public')->delete($diskPath);
        }
        $image->delete();

        return redirect()->back()->with('warning', 'Image has been deleted');
    }

    public function resto()
    {
        $data = Restaurant::with('images')->first();
        $images = collect();
        $totalImages = 0;

        if ($data) {
            $data->load('images');
            $images = $data->images ?? collect();
            $totalImages = $images->count();
        } else {
            $data = Restaurant::create([
                'title' => 'Dining',
                'description' => 'Discover our restaurant and bar.',
            ]);
            $data = Restaurant::with('images')->first();
        }

        return view('admin.pages.restaurant', [
            'data' => $data,
            'images' => $images,
            'totalImages' => $totalImages,
        ]);
    }

    public function saveResto(Request $request, $id)
    {
        $data = Restaurant::findOrFail($id);
        $data->title = $request->input('title');
        $data->description = $request->input('description');
        $data->save();

        return redirect()->back()->with('success', 'Page has been updated successfully');
    }

    public function addRestoImage(Request $request)
    {
        $request->validate([
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        if (! $request->hasFile('image')) {
            return redirect()->back()->with('error', 'No images were uploaded.');
        }

        $maxOrder = (int) Restoimage::where('restaurant_id', $request->restaurant_id)->max('sort_order');

        foreach ($request->file('image') as $image) {
            $path = $image->store('public/images/restaurant');
            $fileName = str_replace('public/images/restaurant/', '', $path);

            $maxOrder++;
            Restoimage::create([
                'image' => $fileName,
                'restaurant_id' => $request->restaurant_id,
                'user_id' => $request->user()?->id,
                'sort_order' => $maxOrder,
            ]);
        }

        return redirect()->back()->with('success', 'Images uploaded successfully!');
    }

    public function updateRestoImage(Request $request, $id)
    {
        $request->validate([
            'caption' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        $row = Restoimage::findOrFail($id);

        if ($request->exists('caption')) {
            $row->caption = $request->input('caption');
        }

        if ($request->hasFile('image')) {
            $diskPath = 'images/restaurant/'.$row->image;
            if (Storage::disk('public')->exists($diskPath)) {
                Storage::disk('public')->delete($diskPath);
            }
            $path = $request->file('image')->store('public/images/restaurant');
            $fileName = str_replace('public/images/restaurant/', '', $path);
            $row->image = $fileName;
        }

        $row->save();

        return redirect()->back()->with('success', 'Image updated.');
    }

    public function reorderRestoImage(Request $request, $id)
    {
        $request->validate(['direction' => 'required|in:up,down']);

        $img = Restoimage::findOrFail($id);
        $rows = Restoimage::where('restaurant_id', $img->restaurant_id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $idx = $rows->search(fn ($r) => (int) $r->id === (int) $img->id);
        if ($idx === false) {
            return redirect()->back();
        }

        $swapIdx = $request->input('direction') === 'up' ? $idx - 1 : $idx + 1;
        if ($swapIdx < 0 || $swapIdx >= $rows->count()) {
            return redirect()->back();
        }

        $a = $rows[$idx];
        $b = $rows[$swapIdx];
        $tmp = $a->sort_order;
        $a->sort_order = $b->sort_order;
        $b->sort_order = $tmp;
        $a->save();
        $b->save();

        return redirect()->back()->with('success', 'Order updated.');
    }

    public function deleteRestoImage($id)
    {
        $image = Restoimage::findOrFail($id);
        $diskPath = 'images/restaurant/'.$image->image;
        if (Storage::disk('public')->exists($diskPath)) {
            Storage::disk('public')->delete($diskPath);
        }
        $image->delete();

        return redirect()->back()->with('warning', 'Image has been deleted');
    }
}
