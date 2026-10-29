<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Job;
use App\Models\User;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Load job listings from the file 
        $joblistings = include database_path('seeders/data/job_listings.php');

        $testuserId = User::where('email' , 'user111@test.com')->value('id');

        // Get user id from user model 
        $userIds = User::where('email','!=','user111@test.com')->pluck('id')->toArray();

        foreach($joblistings as $index => &$listing){

            if($index<2){
                $listing['user_id'] = $testuserId;          
              }
              else{

                // Assign user id to listing   
                $listing['user_id'] = $userIds[array_rand($userIds)];
            }


            // Add timestamps
            $listing['created_at'] = now();
            $listing['updated_at'] = now();
        }


        // 'Insert'
        DB::table('job_listings')->insert($joblistings);
        echo 'Job insertted';

            
    }
}
