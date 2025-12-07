<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Fine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Users
        $this->seedUsers();

        // Seed Fine Configuration
        $this->seedFineConfiguration();

        // Seed Categories
        $this->seedCategories();

        // Seed Books
        $this->seedBooks();

        // Seed Loans
        $this->seedLoans();
    }

    /**
     * Seed User Data
     */
    private function seedUsers(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@perpustakaan.com',
            'phone' => '082112345678',
            'address' => 'Jl. Perpustakaan No. 123, Jakarta',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        // Pustakawan (Librarians)
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@perpustakaan.com',
            'phone' => '082187654321',
            'address' => 'Jl. Merdeka No. 45, Jakarta',
            'role' => 'pustakawan',
            'password' => Hash::make('pustakawan123'),
        ]);

        User::create([
            'name' => 'Bambang Sugiono',
            'email' => 'bambang@perpustakaan.com',
            'phone' => '082198765432',
            'address' => 'Jl. Sudirman No. 67, Jakarta',
            'role' => 'pustakawan',
            'password' => Hash::make('pustakawan123'),
        ]);

        // Members (Anggota)
        User::create([
            'name' => 'Ahmad Wijaya',
            'email' => 'ahmad@email.com',
            'phone' => '085212345678',
            'address' => 'Jl. Raya Bogor No. 12, Bogor',
            'role' => 'anggota',
            'password' => Hash::make('member123'),
        ]);

        User::create([
            'name' => 'Rina Hermawan',
            'email' => 'rina@email.com',
            'phone' => '085298765432',
            'address' => 'Jl. Gatot Subroto No. 89, Jakarta',
            'role' => 'anggota',
            'password' => Hash::make('member123'),
        ]);

        User::create([
            'name' => 'Doni Santoso',
            'email' => 'doni@email.com',
            'phone' => '085345678901',
            'address' => 'Jl. Ahmad Yani No. 34, Bandung',
            'role' => 'anggota',
            'password' => Hash::make('member123'),
        ]);

        User::create([
            'name' => 'Lisa Maulidya',
            'email' => 'lisa@email.com',
            'phone' => '085456789012',
            'address' => 'Jl. Diponegoro No. 56, Medan',
            'role' => 'anggota',
            'password' => Hash::make('member123'),
        ]);
    }

    /**
     * Seed Fine Configuration
     */
    private function seedFineConfiguration(): void
    {
        Fine::create([
            'daily_rate' => 5000,
            'max_fine' => 100000,
        ]);
    }

    /**
     * Seed Category Data
     */
    private function seedCategories(): void
    {
        $categories = [
            [
                'name' => 'Fiksi',
                'description' => 'Buku cerita fiksi, novel, dan roman',
            ],
            [
                'name' => 'Non-Fiksi',
                'description' => 'Buku pengetahuan, biografi, dan referensi',
            ],
            [
                'name' => 'Teknologi',
                'description' => 'Buku tentang teknologi, programming, dan informatika',
            ],
            [
                'name' => 'Pendidikan',
                'description' => 'Buku pelajaran, tutorial, dan panduan belajar',
            ],
            [
                'name' => 'Seni & Budaya',
                'description' => 'Buku tentang seni, musik, dan warisan budaya',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }

    /**
     * Seed Book Data
     */
    private function seedBooks(): void
    {
        $books = [
            // Fiksi
            [
                'category_id' => 1,
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '9789793339345',
                'publisher' => 'Bentang Pustaka',
                'published_year' => 2005,
                'total_copies' => 5,
                'available_copies' => 3,
            ],
            [
                'category_id' => 1,
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'isbn' => '9789793339128',
                'publisher' => 'Hasta Mitra',
                'published_year' => 1980,
                'total_copies' => 4,
                'available_copies' => 2,
            ],
            [
                'category_id' => 1,
                'title' => 'Sang Pemimpi',
                'author' => 'Andrea Hirata',
                'isbn' => '9789793339352',
                'publisher' => 'Bentang Pustaka',
                'published_year' => 2006,
                'total_copies' => 3,
                'available_copies' => 1,
            ],

            // Non-Fiksi
            [
                'category_id' => 2,
                'title' => 'Sapiens: Riwayat Singkat Umat Manusia',
                'author' => 'Yuval Noah Harari',
                'isbn' => '9789793399876',
                'publisher' => 'Gramedia Pustaka Utama',
                'published_year' => 2014,
                'total_copies' => 4,
                'available_copies' => 4,
            ],
            [
                'category_id' => 2,
                'title' => 'Mindset: The New Psychology of Success',
                'author' => 'Carol S. Dweck',
                'isbn' => '9780345472328',
                'publisher' => 'Random House',
                'published_year' => 2006,
                'total_copies' => 3,
                'available_copies' => 3,
            ],

            // Teknologi
            [
                'category_id' => 3,
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '9780132350884',
                'publisher' => 'Prentice Hall',
                'published_year' => 2008,
                'total_copies' => 2,
                'available_copies' => 2,
            ],
            [
                'category_id' => 3,
                'title' => 'The Pragmatic Programmer',
                'author' => 'David Thomas & Andrew Hunt',
                'isbn' => '9780135957059',
                'publisher' => 'Addison-Wesley',
                'published_year' => 2019,
                'total_copies' => 2,
                'available_copies' => 1,
            ],
            [
                'category_id' => 3,
                'title' => 'Laravel: Up & Running',
                'author' => 'Matt Stauffer',
                'isbn' => '9781492041207',
                'publisher' => "O'Reilly Media",
                'published_year' => 2019,
                'total_copies' => 3,
                'available_copies' => 2,
            ],

            // Pendidikan
            [
                'category_id' => 4,
                'title' => 'Matematika SMA Kelas XI',
                'author' => 'Kementerian Pendidikan',
                'isbn' => '9789876543210',
                'publisher' => 'Depdiknas',
                'published_year' => 2021,
                'total_copies' => 6,
                'available_copies' => 4,
            ],
            [
                'category_id' => 4,
                'title' => 'Bahasa Indonesia untuk SMA',
                'author' => 'Kementerian Pendidikan',
                'isbn' => '9879876543211',
                'publisher' => 'Depdiknas',
                'published_year' => 2021,
                'total_copies' => 5,
                'available_copies' => 3,
            ],

            // Seni & Budaya
            [
                'category_id' => 5,
                'title' => 'Sejarah Musik Indonesia',
                'author' => 'Corrie Tan',
                'isbn' => '9789793345678',
                'publisher' => 'PT Tempoe',
                'published_year' => 2010,
                'total_copies' => 2,
                'available_copies' => 2,
            ],
            [
                'category_id' => 5,
                'title' => 'Batik: Warisan Budaya Dunia',
                'author' => 'Ari Wulandari',
                'isbn' => '9789793345679',
                'publisher' => 'Gramedia',
                'published_year' => 2011,
                'total_copies' => 3,
                'available_copies' => 2,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }

    /**
     * Seed Loan Data
     */
    private function seedLoans(): void
    {
        // Get users by role
        $members = User::where('role', 'anggota')->get();

        if ($members->isEmpty()) {
            return;
        }

        // Active loans
        Loan::create([
            'user_id' => $members[0]->id,
            'book_id' => 1,
            'borrow_date' => Carbon::now()->subDays(5),
            'due_date' => Carbon::now()->addDays(2),
            'return_date' => null,
            'status' => 'approved',
            'fine_amount' => 0,
        ]);

        Loan::create([
            'user_id' => $members[1]->id,
            'book_id' => 2,
            'borrow_date' => Carbon::now()->subDays(10),
            'due_date' => Carbon::now()->subDays(3),
            'return_date' => null,
            'status' => 'overdue',
            'fine_amount' => 35000, // 7 days overdue x 5000
        ]);

        // Pending loans
        Loan::create([
            'user_id' => $members[2]->id,
            'book_id' => 3,
            'borrow_date' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(7),
            'return_date' => null,
            'status' => 'pending',
            'fine_amount' => 0,
        ]);

        // Returned loans
        Loan::create([
            'user_id' => $members[3]->id,
            'book_id' => 4,
            'borrow_date' => Carbon::now()->subDays(15),
            'due_date' => Carbon::now()->subDays(8),
            'return_date' => Carbon::now()->subDays(5),
            'status' => 'returned',
            'fine_amount' => 0,
        ]);

        Loan::create([
            'user_id' => $members[0]->id,
            'book_id' => 6,
            'borrow_date' => Carbon::now()->subDays(20),
            'due_date' => Carbon::now()->subDays(13),
            'return_date' => Carbon::now()->subDays(12),
            'status' => 'returned',
            'fine_amount' => 0,
        ]);
    }
}
