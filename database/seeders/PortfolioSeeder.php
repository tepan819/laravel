<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\Project;
class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        Profile::updateOrCreate(
            ['email' => 'pemilik@example.com'],
            [
                'name' => 'Nama Lengkap Anda',
                'headline' => 'Web Developer',
                'bio' => 'Saya mengembangkan aplikasi web dan solusi digital.',
                'email' => 'pemilik@example.com',
                'phone' => '08xxxxxxxxxx',
                'location' => 'Indonesia',
            ]
        );
        Project::updateOrCreate(
            ['slug' => 'website-personal-portfolio'],
            [
                'title' => 'Website Personal Portfolio',
                'category' => 'Web Development',
                'description' => 'Website portfolio berbasis Laravel dan MySQL.',
                'tech_stack' => ['Laravel 13', 'PHP', 'MySQL', 'Bootstrap'],
                'is_featured' => true,
                'status' => 'published',
            ]
        );
    }
}