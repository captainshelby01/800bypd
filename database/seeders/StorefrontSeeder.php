<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Review;

class StorefrontSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Super Admin Account Seeding
        User::updateOrCreate(
            ['email' => 'admin@800bypd.com'],
            [
                'name' => 'Main Admin (800bypd)',
                'password' => Hash::make('AdminPassword2026!'),
                'role' => 'admin',
                'phone' => '08164254442',
            ]
        );

        // 1. Categories for 800bypd
        $storyBooks = Category::updateOrCreate(
            ['slug' => 'childrens-story-books'],
            [
                'name' => "Children's Story Books",
                'description' => 'Captivating, inspiring, and fun illustrated story books written by WrittenbyPD for young curious minds.'
            ]
        );

        $puzzles = Category::updateOrCreate(
            ['slug' => 'jigsaw-puzzles'],
            [
                'name' => 'Jigsaw Puzzles',
                'description' => 'Vibrant, brain-boosting jigsaw puzzles for kids of all ages designed to build critical thinking.'
            ]
        );

        $colouring = Category::updateOrCreate(
            ['slug' => 'colouring-books'],
            [
                'name' => 'Colouring Books',
                'description' => 'Creative and interactive colouring books designed to unleash imagination and artistic expression.'
            ]
        );

        // 2. Story Books
        $p1 = Product::updateOrCreate(
            ['slug' => 'adventures-of-the-little-explorer'],
            [
                'category_id' => $storyBooks->id,
                'name' => 'Adventures of the Little Explorer (Hardcover)',
                'sku' => 'PD-STORY-001',
                'price' => 7500.00,
                'sale_price' => 6500.00,
                'stock_quantity' => 50,
                'description' => 'Follow Leo on an enchanting bedtime adventure through magical forests. Full of lessons on courage, kindness, and friendship.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        $p2 = Product::updateOrCreate(
            ['slug' => 'the-boy-who-spoke-to-the-stars'],
            [
                'category_id' => $storyBooks->id,
                'name' => 'The Boy Who Spoke to the Stars',
                'sku' => 'PD-STORY-002',
                'price' => 6000.00,
                'stock_quantity' => 45,
                'description' => 'A heartwarming tale about curiosity, space exploration, and dreaming big. Written by WrittenbyPD.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // 3. Jigsaw Puzzles
        $p3 = Product::updateOrCreate(
            ['slug' => 'safari-animal-kingdom-jigsaw-puzzle'],
            [
                'category_id' => $puzzles->id,
                'name' => 'Safari Animal Kingdom 100-Piece Jigsaw Puzzle',
                'sku' => 'PD-PUZZ-001',
                'price' => 9500.00,
                'sale_price' => 8500.00,
                'stock_quantity' => 30,
                'description' => 'Vibrant, durable 100-piece safari animal jigsaw puzzle with non-toxic soy-based ink. Fun for family game night!',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        $p4 = Product::updateOrCreate(
            ['slug' => 'magical-space-galaxy-floor-puzzle'],
            [
                'category_id' => $puzzles->id,
                'name' => 'Magical Space Galaxy 60-Piece Floor Puzzle',
                'sku' => 'PD-PUZZ-002',
                'price' => 11000.00,
                'stock_quantity' => 20,
                'description' => 'Large floor puzzle featuring planets, rockets, and bright constellations designed to enhance problem-solving skills.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // 4. Colouring Books
        $p5 = Product::updateOrCreate(
            ['slug' => 'my-first-world-of-wonder-colouring-book'],
            [
                'category_id' => $colouring->id,
                'name' => 'My First World of Wonder Colouring Book',
                'sku' => 'PD-COL-001',
                'price' => 4500.00,
                'sale_price' => 3800.00,
                'stock_quantity' => 60,
                'description' => 'Over 80 pages of thick, bleed-resistant paper filled with cheerful illustrations of animals, places, and fun characters.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        $p6 = Product::updateOrCreate(
            ['slug' => 'super-kids-mindfulness-doodle-book'],
            [
                'category_id' => $colouring->id,
                'name' => 'Super Kids Mindfulness & Doodle Activity Book',
                'sku' => 'PD-COL-002',
                'price' => 5000.00,
                'stock_quantity' => 40,
                'description' => 'Interactive doodle pages designed to promote relaxation, focus, and positive self-affirmations for growing children.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // Seed Customer Testimonials
        Review::updateOrCreate(
            ['product_id' => $p1->id, 'customer_name' => 'Mrs. Folake K. (Lagos)'],
            [
                'rating' => 5,
                'comment' => 'My 6-year-old daughter absolutely loves bedtime story reading with this book! Delivery to Lekki took only 24 hours.',
            ]
        );

        Review::updateOrCreate(
            ['product_id' => $p3->id, 'customer_name' => 'Mr. Chidi O. (Abuja)'],
            [
                'rating' => 5,
                'comment' => 'High quality puzzle pieces that don\'t tear easily. Paystack payment was super seamless!',
            ]
        );

        // Seed Coupons
        Coupon::updateOrCreate(
            ['code' => '800BYPD10'],
            [
                'type' => 'percent',
                'value' => 10.00,
                'min_spend' => 10000.00,
            ]
        );
    }
}
