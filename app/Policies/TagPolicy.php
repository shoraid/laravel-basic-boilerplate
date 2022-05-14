<?php

namespace App\Policies;

use App\Enums\PermissionEnum;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
	use HandlesAuthorization;

	/**
	 * Determine whether the user can view any models.
	 *
	 * @param  \App\Models\User  $user
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function viewAny(User $user)
	{
		return $user->can(PermissionEnum::SEE_ALL_TAGS);
	}

	/**
	 * Determine whether the user can view the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Tag  $tag
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function view(User $user, Tag $tag)
	{
		return $user->can(PermissionEnum::SEE_SELECTED_TAG);
	}

	/**
	 * Determine whether the user can create models.
	 *
	 * @param  \App\Models\User  $user
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function create(User $user)
	{
		return $user->can(PermissionEnum::CREATE_TAG);
	}

	/**
	 * Determine whether the user can update the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Tag  $tag
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function update(User $user, Tag $tag)
	{
		return $user->can(PermissionEnum::UPDATE_TAG);
	}

	/**
	 * Determine whether the user can delete the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Tag  $tag
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function delete(User $user, Tag $tag)
	{
		return $user->can(PermissionEnum::DELETE_TAG);
	}

	/**
	 * Determine whether the user can restore the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Tag  $tag
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function restore(User $user, Tag $tag)
	{
		//
	}

	/**
	 * Determine whether the user can permanently delete the model.
	 *
	 * @param  \App\Models\User  $user
	 * @param  \App\Models\Tag  $tag
	 * @return \Illuminate\Auth\Access\Response|bool
	 */
	public function forceDelete(User $user, Tag $tag)
	{
		//
	}
}
