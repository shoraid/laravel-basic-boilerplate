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
			['name' => PermissionEnum::CAN_SEE_ALL_CATEGORIES, 'guard_name' => 'web'],
			['name' => PermissionEnum::CAN_CREATE_CATEGORY, 'guard_name' => 'web'],
			['name' => PermissionEnum::CAN_UPDATE_CATEGORY, 'guard_name' => 'web'],
			['name' => PermissionEnum::CAN_DELETE_CATEGORY, 'guard_name' => 'web'],
		]);
	}
}
