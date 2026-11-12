<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('waters');

        // whereHas(): ?has_waters=1 bolsa diňe suwy bar kategoriýalary görkez
        if ($request->boolean('has_waters')) {
            $query->whereHas('waters');
        }

        $categories = $query->latest()->get();
        $activeCategoriesCount = Category::whereHas('waters')->count();

        return view('categories.index', compact('categories', 'activeCategoriesCount'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Category::validationRules());
        $validated['icon'] = $validated['icon'] ?? '💧';
        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', __('messages.category_created'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate(Category::validationRules());
        $validated['icon'] = $validated['icon'] ?? '💧';
        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', __('messages.category_updated'));
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', __('messages.category_deleted'));
    }
}
