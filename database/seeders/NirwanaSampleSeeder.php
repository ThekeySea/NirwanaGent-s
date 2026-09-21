<?php

namespace Database\Seeders;

use App\Models\Barber;
use App\Models\Media;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Service;
use Illuminate\Database\Seeder;

class NirwanaSampleSeeder extends Seeder
{
    public function run(): void
    {
        $styling = ProductCategory::updateOrCreate(
            ['slug' => 'styling-sample'],
            ['name' => 'Styling (SAMPLE)', 'description' => 'Kategori sample, ganti dengan data resmi.']
        );
        $care = ProductCategory::updateOrCreate(
            ['slug' => 'care-sample'],
            ['name' => 'Perawatan (SAMPLE)', 'description' => 'Kategori sample, ganti dengan data resmi.']
        );

        $services = [
            [
                'name' => 'Classic Haircut (SAMPLE)',
                'slug' => 'classic-haircut-sample',
                'description' => 'Potong presisi, cuci, dan styling akhir sesuai bentuk kepala.',
                'inclusions' => "Konsultasi singkat\nPotong presisi\nCuci rambut\nStyling akhir",
                'price' => 75000,
                'duration_minutes' => 45,
                'is_active' => true,
            ],
            [
                'name' => 'Beard Trim (SAMPLE)',
                'slug' => 'beard-trim-sample',
                'description' => 'Rapikan garis jenggot dengan towel hangat dan finishing oil.',
                'inclusions' => "Pemetaan garis jenggot\nTrim detail\nTowel hangat\nFinishing oil",
                'price' => 50000,
                'duration_minutes' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Haircut + Beard (SAMPLE)',
                'slug' => 'haircut-beard-sample',
                'description' => 'Paket potong dan kerapian jenggot dalam satu kunjungan.',
                'inclusions' => "Classic haircut\nBeard trim\nStyling akhir",
                'price' => 110000,
                'duration_minutes' => 75,
                'is_active' => true,
            ],
        ];

        foreach ($services as $data) {
            Service::updateOrCreate(['slug' => $data['slug']], $data);
        }

        $barbers = [
            [
                'name' => 'Arya (SAMPLE)',
                'slug' => 'arya-sample',
                'role' => 'Barber',
                'bio' => 'Fokus pada potong klasik dan fade rapi. Data sample.',
                'specialties' => 'Classic cut, fade',
                'is_active' => true,
            ],
            [
                'name' => 'Bagas (SAMPLE)',
                'slug' => 'bagas-sample',
                'role' => 'Senior Barber',
                'bio' => 'Fokus pada kerapian jenggot dan styling. Data sample.',
                'specialties' => 'Beard trim, styling',
                'is_active' => true,
            ],
        ];

        foreach ($barbers as $data) {
            Barber::updateOrCreate(['slug' => $data['slug']], $data);
        }

        $allServices = Service::whereIn('slug', ['classic-haircut-sample', 'beard-trim-sample', 'haircut-beard-sample'])->get();
        foreach (Barber::whereIn('slug', ['arya-sample', 'bagas-sample'])->get() as $barber) {
            $barber->services()->sync($allServices->pluck('id')->all());
        }

        $products = [
            [
                'name' => 'Pomade Classic (SAMPLE)',
                'slug' => 'pomade-classic-sample',
                'category_id' => $styling->id,
                'description' => 'Pomade hold medium dengan hasil natural. Data sample.',
                'usage_instructions' => 'Ambil seujung jari, ratakan di telapak, aplikasikan ke rambut kering.',
                'price' => 85000,
                'stock' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'Beard Oil (SAMPLE)',
                'slug' => 'beard-oil-sample',
                'category_id' => $care->id,
                'description' => 'Minyak jenggot untuk kerapian harian. Data sample.',
                'usage_instructions' => 'Teteskan 2 sampai 3 tetes, pijat ke jenggot dan kulit.',
                'price' => 95000,
                'stock' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Clay Matte (SAMPLE)',
                'slug' => 'clay-matte-sample',
                'category_id' => $styling->id,
                'description' => 'Clay hasil matte untuk volume. Data sample, sedang nonaktif.',
                'usage_instructions' => 'Gunakan sedikit pada rambut kering untuk hasil matte.',
                'price' => 90000,
                'stock' => 0,
                'is_active' => false,
            ],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(['slug' => $data['slug']], $data);
        }

        $gallery = [
            ['collection' => 'gallery', 'path' => '', 'alt' => 'Suasana kursi barber Nirwana Gents (sample)', 'caption' => 'Ruang potong'],
            ['collection' => 'gallery', 'path' => '', 'alt' => 'Detail alat potong tertata (sample)', 'caption' => 'Detail alat'],
            ['collection' => 'gallery', 'path' => '', 'alt' => 'Cermin dan pencahayaan hangat barbershop (sample)', 'caption' => 'Interior'],
        ];

        foreach ($gallery as $item) {
            Media::firstOrCreate(
                ['caption' => $item['caption'], 'collection' => 'gallery'],
                $item
            );
        }
    }
}
