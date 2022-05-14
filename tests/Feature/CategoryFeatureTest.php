<?php

namespace Tests\Feature;

use App\Enums\PermissionEnum;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\Tests\CategoryPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryFeatureTest extends TestCase
{
	use RefreshDatabase;

	private Category $category;

	private array $data;

	private User $user;

	public function setUp(): void
	{
		parent::setUp();
		$this->seed(CategoryPermissionSeeder::class);

		$this->category = Category::factory()->create();

		$this->data = Category::factory()->raw();

		$this->user = User::factory()->create();
	}

	/** @test */
	public function authorized_user_can_see_all_categories()
	{
		$this->user->givePermissionTo(PermissionEnum::SEE_ALL_CATEGORIES);

		$response = $this
			->actingAs($this->user)
			->get('/cms/categories');

		$response
			->assertStatus(200)
			->assertViewIs('cms.categories.index')
			->assertViewHas('categories')
			->assertSee($this->category->name);
	}

	/** @test */
	public function authorized_user_can_visit_create_category_page()
	{
		$this->user->givePermissionTo(PermissionEnum::CREATE_CATEGORY);

		$response = $this
			->actingAs($this->user)
			->get('/cms/categories/create');

		$response
			->assertStatus(200)
			->assertViewIs('cms.categories.create');
	}

	/** @test */
	public function authorized_user_can_add_new_category()
	{
		$this->user->givePermissionTo(PermissionEnum::CREATE_CATEGORY);

		$response = $this
			->actingAs($this->user)
			->post('/cms/categories', $this->data);

		$response
			->assertRedirect('/cms/categories')
			->assertSessionHas('success', __('messages.data_saved'));

		$this->assertDatabaseHas(Category::class, $this->data);
	}

	/** @test */
	public function authorized_user_can_visit_edit_category_page()
	{
		$this->user->givePermissionTo(PermissionEnum::UPDATE_CATEGORY);

		$response = $this
			->actingAs($this->user)
			->get("/cms/categories/{$this->category->id}/edit");

		$response
			->assertStatus(200)
			->assertViewIs('cms.categories.edit')
			->assertViewHas('category', $this->category);
	}

	/** @test */
	public function authorized_user_can_update_category()
	{
		$this->user->givePermissionTo(PermissionEnum::UPDATE_CATEGORY);

		$response = $this
			->actingAs($this->user)
			->patch("/cms/categories/{$this->category->id}", $this->data);

		$response
			->assertRedirect('/cms/categories')
			->assertSessionHas('success', __('messages.data_saved'));

		$this->assertDatabaseHas(Category::class, $this->data);
	}

	/** @test */
	public function authorized_user_can_delete_category()
	{
		$this->user->givePermissionTo(PermissionEnum::DELETE_CATEGORY);

		$response = $this
			->actingAs($this->user)
			->delete("/cms/categories/{$this->category->id}");

		$response->assertRedirect();

		$this->assertDatabaseCount(Category::class, 0);
	}

	/** @test */
	public function unauthorized_user_cannot_see_all_categories()
	{
		$response = $this->get('/cms/categories');

		$response->assertForbidden();
	}

	/** @test */
	public function unauthorized_user_cannot_visit_create_category_page()
	{
		$response = $this->get('/cms/categories/create');

		$response->assertForbidden();
	}

	/** @test */
	public function unauthorized_user_cannot_add_new_category()
	{
		$response = $this->post('/cms/categories', $this->data);

		$response->assertForbidden();
	}

	/** @test */
	public function unauthorized_user_cannot_visit_edit_category_page()
	{
		$response = $this->get("/cms/categories/{$this->category->id}/edit");

		$response->assertForbidden();
	}

	/** @test */
	public function unauthorized_user_cannot_update_category()
	{
		$response = $this->put("/cms/categories/{$this->category->id}", $this->data);

		$response->assertForbidden();
	}

	/** @test */
	public function unauthorized_user_cannot_delete_category()
	{
		$response = $this->delete("/cms/categories/{$this->category->id}");

		$response->assertForbidden();
	}
}
