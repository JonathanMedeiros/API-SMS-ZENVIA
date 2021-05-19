<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('applications')->insert(
            [
                [
                    'company'   => 'Prefeitura de Vitória de Santo Antão',
                    'name'      => 'Sistema de vacina - Prefeitura da Vitória',
                    'token'     => 'eyJhbGciOiJIUzI1VIisInR5cCI6IkpXVCJ9.eyJleHAiTOEzODY4OTkxMzEsImlzcyI6ImppcmE6MTU0RIAk1OTUiLCJPE',
                    'active'    => true,
                    'created_at'=> now()
                ],   
                [
                    'company'   => 'Prefeitura de Moreno',
                    'name'      => 'Sistema de vacina - Prefeitura da Moreno',
                    'token'     => 'eyJhbGciOiJIUzI1MOIsInR5cCI6IkpXVCJ9.eyJleHAiREzODY4OTkxMzEsImlzcyI6ImppcmE6MTU0NOk1OTUiLCJPE',
                    'active'    => true,
                    'created_at'=> now()
                ],  
            ]
        );
    }
}
