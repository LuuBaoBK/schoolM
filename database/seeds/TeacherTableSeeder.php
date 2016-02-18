<?php

use Illuminate\Database\Seeder;

class TeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<=9; $i++){
            $mobilephone = '0';
            $homephone = '08';
            for($k=0; $k<9; $k++){
                $mobilephone = $mobilephone.rand(0,9);
                if($k < 7){
                    $homephone = $homephone.rand(0,9);
                }
            }
    		DB::table('teachers')->insert([
    			'id' =>	't_000000'.$i,
                'mobilephone' => $mobilephone,
                'homephone' => $homephone,
                'group' => $i+2,
                'position' => rand(2,6),
                'specialized' => 'toan'.$i,
                'incomingday' => "2015-11-".$i,
                'doable' => '0'             
        	]);
    	}
        for($i=0; $i<=9; $i++){
            $mobilephone = '0';
            $homephone = '08';
            for($k=0; $k<9; $k++){
                $mobilephone = $mobilephone.rand(0,9);
                if($k < 7){
                    $homephone = $homephone.rand(0,9);
                }
            }
            DB::table('teachers')->insert([
                'id' => 't_000001'.$i,
                'mobilephone' => $mobilephone,
                'homephone' => $homephone,
                'group' => rand(2,11),
                'position' => rand(2,6),
                'specialized' => 'toan'.$i,
                'incomingday' => "2015-11-".$i,
                'doable' => '0'              
            ]);
        }
    }
}
