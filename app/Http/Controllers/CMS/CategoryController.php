<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
	public function __construct()
	{
		$this->authorizeResource(Category::class);
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$categories = Category::all();

		return view('cms.categories.index', compact('categories'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('cms.categories.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(CategoryRequest $request)
	{
		Category::create(['name' => $request->name]);

		return redirect()
			->route('cms.categories.index')
			->with('success', __('messages.data_saved'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Category $category)
	{
		return view('cms.categories.edit', compact('category'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(CategoryRequest $request, Category $category)
	{
		$category->update(['name' => $request->name]);

		return redirect()
			->route('cms.categories.index')
			->with('success', __('messages.data_saved'));
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Category $category)
	{
		try {
			$category->delete();

			return back()->with('success', __('messages.data_deleted'));
		} catch (\Throwable $th) {
			return back()->with('failed', __('messages.cannot_delete'));
		}
	}
}
