<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Water;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WaterController extends Controller
{
    public function index(Request $request)
    {
        $query = Water::with('category');

        // whereHas(): saýlanan kategoriýa boýunça süzmek
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->integer('category'));
            });
        }

        // whereHas(): kategoriýanyň ady boýunça gözleg (tm / ru / en)
        if ($request->filled('category_name')) {
            $term = '%'.$request->string('category_name').'%';
            $query->whereHas('category', function ($q) use ($term) {
                $q->where('name_tm', 'like', $term)
                  ->orWhere('name_ru', 'like', $term)
                  ->orWhere('name_en', 'like', $term);
            });
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->string('search').'%');
        }

        if ($request->filled('volume')) {
            $query->where('volume', (string) $request->string('volume'));
        }

        $waters = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::all();
        $volumes = Water::query()->distinct()->orderBy('volume')->pluck('volume');

        return view('waters.index', compact('waters', 'categories', 'volumes'));
    }

    public function show(Water $water)
    {
        $water->load('category');

        $relatedWaters = Water::where('category_id', $water->category_id)
            ->where('id', '!=', $water->id)
            ->take(4)
            ->get();

        return view('waters.show', compact('water', 'relatedWaters'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('waters.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Water::validationRules());

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('waters', 'public');
        }

        Water::create($validated);

        return redirect()->route('waters.index')->with('success', __('messages.water_created'));
    }

    public function edit(Water $water)
    {
        $categories = Category::all();

        return view('waters.edit', compact('water', 'categories'));
    }

    public function update(Request $request, Water $water)
    {
        $validated = $request->validate(Water::validationRules());

        if ($request->hasFile('image')) {
            $this->deleteLocalImage($water);
            $validated['image'] = $request->file('image')->store('waters', 'public');
        } else {
            unset($validated['image']); // täze surat ýok bolsa köne suraty saklaýarys
        }

        $water->update($validated);

        return redirect()->route('waters.index')->with('success', __('messages.water_updated'));
    }

    public function destroy(Water $water)
    {
        $this->deleteLocalImage($water);
        $water->delete();

        return redirect()->route('waters.index')->with('success', __('messages.water_deleted'));
    }

    /** Diňe özümiziň ýüklän suratlarymyzy pozýarys (URL suratlary däl) */
    private function deleteLocalImage(Water $water): void
    {
        if ($water->image && ! str_starts_with($water->image, 'http')) {
            Storage::disk('public')->delete($water->image);
        }
    }
}
