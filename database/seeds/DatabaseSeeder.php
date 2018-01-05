<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Basic resources
        $this->call(DepartmentsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(DegreeCourseTypesTableSeeder::class);
        $this->call(SemestersTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(MobilityStatusesTableSeeder::class);

        // Example data
        $this->call(UniversityBranchesTableSeeder::class);
        $this->call(DegreeCoursesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(RegistersTableSeeder::class);
        $this->call(BankAccountsTableSeeder::class);
    }
}
