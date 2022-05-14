<?php

namespace Database\Seeders\Tests;

use App\Enums\PermissionEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryPermissionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('permissions')->insert([
			['name' => PermissionEnum::SEE_ALL_CATEGORIES, 'guard_name' => 'web'],
			['name' => PermissionEnum::CREATE_CATEGORY, 'guard_name' => 'web'],
			['name' => PermissionEnum::UPDATE_CATEGORY, 'guard_name' => 'web'],
			['name' => PermissionEnum::DELETE_CATEGORY, 'guard_name' => 'web'],
		]);
	}
}
