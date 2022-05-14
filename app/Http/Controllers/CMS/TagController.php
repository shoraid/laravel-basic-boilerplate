<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;

class TagController extends Controller
{
	public function __construct()
	{
		$this->authorizeResource(Tag::class);
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$tags = Tag::all();

		return view('cms.tags.index', compact('tags'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('cms.tags.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(TagRequest $request)
	{
		Tag::create(['name' => $request->name]);

		return redirect()
			->route('cms.tags.index')
			->with('success', __('messages.data_saved'));
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Tag $tag)
	{
		return view('cms.tags.show', compact('tag'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Tag $tag)
	{
		return view('cms.tags.edit', compact('tag'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(TagRequest $request, Tag $tag)
	{
		$tag->update(['name' => $request->name]);

		return redirect()
			->route('cms.tags.index')
			->with('success', __('messages.data_saved'));
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Tag $tag)
	{
		try {
			$tag->delete();

			return redirect()
				->route('cms.tags.index')
				->with('success', __('messages.data_deleted'));
		} catch (\Throwable $th) {
			return redirect()
				->route('cms.tags.index')
				->with('failed', __('messages.cannot_delete'));
		}
	}
}
