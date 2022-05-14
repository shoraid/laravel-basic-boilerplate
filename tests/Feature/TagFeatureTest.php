<?php

namespace Tests\Feature;

use App\Enums\PermissionEnum;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\Tests\TagPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagFeatureTest extends TestCase
{
	use RefreshDatabase;

	private array $data;

	private Tag $tag;

	private User $user;

	public function setUp(): void
	{
		parent::setUp();
		$this->seed(TagPermissionSeeder::class);

		$this->data = Tag::factory()->raw();

		$this->tag = Tag::factory()->create();

		$this->user = User::factory()->create();
	}

	/** @test */
	public function authorized_user_can_see_all_tags()
	{
		$this->user->givePermissionTo(PermissionEnum::SEE_ALL_TAGS);

		$response = $this
			->actingAs($this->user)
			->get('/cms/tags');

		$response
			->assertStatus(200)
			->assertViewIs('cms.tags.index')
			->assertViewHas('tags')
			->assertSee($this->tag->name);
	}

	/** @test */
	public function authorized_user_can_visit_create_tag_page()
	{
		$this->user->givePermissionTo(PermissionEnum::CREATE_TAG);

		$response = $this
			->actingAs($this->user)
			->get('/cms/tags/create');

		$response
			->assertStatus(200)
			->assertViewIs('cms.tags.create');
	}

	/** @test */
	public function authorized_user_can_add_new_tag()
	{
		$this->user->givePermissionTo(PermissionEnum::CREATE_TAG);

		$response = $this
			->actingAs($this->user)
			->post('/cms/tags', $this->data);

		$response
			->assertRedirect('/cms/tags')
			->assertSessionHas('success');

		$this->assertDatabaseHas(Tag::class, $this->data);
	}

	/** @test */
	public function authorized_user_can_see_selected_tag()
	{
		$this->user->givePermissionTo(PermissionEnum::SEE_SELECTED_TAG);

		$response = $this
			->actingAs($this->user)
			->get("/cms/tags/{$this->tag->id}");

		$response
			->assertStatus(200)
			->assertViewIs('cms.tags.show')
			->assertViewHas('tag');
	}

	/** @test */
	public function authorized_user_can_visit_edit_tag_page()
	{
		$this->user->givePermissionTo(PermissionEnum::UPDATE_TAG);

		$response = $this
			->actingAs($this->user)
			->get("/cms/tags/{$this->tag->id}/edit");

		$response
			->assertStatus(200)
			->assertViewIs('cms.tags.edit')
			->assertViewHas('tag');
	}

	/** @test */
	public function authorized_user_can_update_tag()
	{
		$this->user->givePermissionTo(PermissionEnum::UPDATE_TAG);

		$response = $this
			->actingAs($this->user)
			->patch("/cms/tags/{$this->tag->id}", $this->data);

		$response
			->assertRedirect('/cms/tags')
			->assertSessionHas('success', __('messages.data_saved'));

		$this->assertDatabaseHas(Tag::class, $this->data);
	}

	/** @test */
	public function authorized_user_can_delete_tag()
	{
		$this->user->givePermissionTo(PermissionEnum::DELETE_TAG);

		$response = $this
			->actingAs($this->user)
			->delete("/cms/tags/{$this->tag->id}");

		$response->assertRedirect();

		$this->assertDatabaseCount(Tag::class, 0);
	}

	/** @test */
	public function unauthorized_user_cannot_see_all_tags()
	{
		$response = $this->get('/cms/tags');

		$response->assertForbidden();
	}

	/** @test */
	public function unauthorized_user_cannot_visit_create_tag_page()
	{
		$response = $this->get('/cms/tags/create');

		$response->assertForbidden();
	}

	/** @test */
	public function unauthorized_user_cannot_add_new_tag()
	{
		$response = $this->post('/cms/tags', $this->data);

		$response->assertForbidden();
	}

	/** @test */
	public function unauthorized_user_cannot_see_selected_tag()
	{
		$response = $this->get("/cms/tags/{$this->tag->id}");

		$response->assertForbidden();
	}

	/** @test */
	public function unauthorized_user_cannot_visit_edit_tag_page()
	{
		$response = $this->get("/cms/tags/{$this->tag->id}/edit");

		$response->assertForbidden();
	}

	/** @test */
	public function unauthorized_user_cannot_update_tag()
	{
		$response = $this->put("/cms/tags/{$this->tag->id}", $this->data);

		$response->assertForbidden();
	}

	/** @test */
	public function unauthorized_user_cannot_delete_tag()
	{
		$response = $this->delete("/cms/tags/{$this->tag->id}");

		$response->assertForbidden();
	}
}
