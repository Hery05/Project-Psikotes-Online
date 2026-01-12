<?php

namespace App\Http\Controllers\HRD;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories with optional search and pagination.
     */
    public function index(Request $request)
    {
        $search = $request->q;

        $categories = Category::withCount('questions')
            ->when($search, fn($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('hrd.categories.index', compact('categories', 'search'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('hrd.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string',
            'duration'      => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'weight'        => 'required|integer|min:0|max:100',
        ]);

        Category::create($data);

        return redirect()
            ->route('hrd.categories.index')
            ->with('success','Kategori berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('hrd.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'          => 'required|string',
            'duration'      => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
            'weight'        => 'required|integer|min:0|max:100',
        ]);

        $category->update($data);

        return redirect()
            ->route('hrd.categories.index')
            ->with('success','Kategori berhasil diperbarui');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('hrd.categories.index')
            ->with('success', 'Kategori dihapus');
    }
}
