<?php

namespace Database\Seeders\Tests;

use App\Enums\PermissionEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagPermissionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('permissions')->insert([
			['name' => PermissionEnum::SEE_ALL_TAGS, 'guard_name' => 'web'],
			['name' => PermissionEnum::SEE_SELECTED_TAG, 'guard_name' => 'web'],
			['name' => PermissionEnum::CREATE_TAG, 'guard_name' => 'web'],
			['name' => PermissionEnum::UPDATE_TAG, 'guard_name' => 'web'],
			['name' => PermissionEnum::DELETE_TAG, 'guard_name' => 'web'],
		]);
	}
}
