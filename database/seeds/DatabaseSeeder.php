<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder  {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// $this->call('UserTableSeeder');
/*        $this->call('CantonsTableSeeder');
        $this->call('CivilitesTableSeeder');
        $this->call('PaysTableSeeder');
        $this->call('ProfessionsTableSeeder');
        $this->call('Adresse_typesTableSeeder');*/
        $this->call('OrganisateursTableSeeder');
        $this->call('ColloqueTableSeeder');

	}

}
