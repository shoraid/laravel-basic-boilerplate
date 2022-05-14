<?php

namespace App\Enums;

class PermissionEnum
{
	// Categories
	const SEE_ALL_CATEGORIES = 'See all categories';
	const CREATE_CATEGORY = 'Create category';
	const UPDATE_CATEGORY = 'Update category';
	const DELETE_CATEGORY = 'Delete category';

	// Tags
	const SEE_ALL_TAGS = 'See all tags';
	const SEE_SELECTED_TAG = 'See selected tag';
	const CREATE_TAG = 'Create tag';
	const UPDATE_TAG = 'Update tag';
	const DELETE_TAG = 'Delete tag';
}
