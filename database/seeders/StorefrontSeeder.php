<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Setting;
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
                'name' => 'Main Admin',
                'password' => Hash::make('AdminPassword2026!'),
                'role' => 'admin',
                'phone' => '08164254442',
            ]
        );

        // 1. Checkout Settings: Minimum Order Quantity (Default: 3 items)
        Setting::set('checkout_min_order_quantity', 3, 'checkout', 'integer');

        // 2. The Four Main Product Categories
        $puzzles = Category::updateOrCreate(
            ['slug' => 'jigsaw-puzzles'],
            [
                'name' => 'Jigsaw Puzzles',
                'description' => 'Vibrant, brain-boosting jigsaw puzzles with Easy (6 pieces) and Intermediate (12 pieces) levels designed for young thinkers.'
            ]
        );

        $colouring = Category::updateOrCreate(
            ['slug' => 'coloring-books'],
            [
                'name' => 'Coloring Books',
                'description' => 'Creative and interactive coloring books designed to unleash imagination, fine motor skills, and artistic expression.'
            ]
        );

        $flashcards = Category::updateOrCreate(
            ['slug' => 'flashcards'],
            [
                'name' => 'Flashcards',
                'description' => 'Engaging educational flashcards available in Pocket Size (portable) and Big Size (classroom/home play) for early mastery.'
            ]
        );

        $storyBooks = Category::updateOrCreate(
            ['slug' => 'storybooks'],
            [
                'name' => 'Storybooks',
                'description' => 'Captivating, inspiring, and fun illustrated storybooks written by WrittenbyPD for young curious minds.'
            ]
        );

        // Keep audio category for audio companion listeners
        $audios = Category::updateOrCreate(
            ['slug' => 'childrens-audios'],
            [
                'name' => 'Audios',
                'description' => 'Bedtime story audiobooks and audio series narrated by WrittenbyPD, streaming directly on Spotify.'
            ]
        );

        // 3. Products: FLASHCARDS (with Pocket Size & Big Size variations)
        $fc1 = Product::updateOrCreate(
            ['sku' => 'PD-FC-001'],
            [
                'category_id' => $flashcards->id,
                'name' => 'Everyday Words & Numbers Flashcards',
                'slug' => 'everyday-words-and-numbers-flashcards',
                'price' => 3500.00,
                'stock_quantity' => 100,
                'description' => 'Educational flashcards covering everyday vocabulary, numbers, and basic phonics. Available in convenient Pocket Size for on-the-go learning and Big Size for tabletop interactive play.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        $fc1_v1 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-FC-001-PKT'],
            [
                'product_id' => $fc1->id,
                'name' => 'Pocket Size',
                'price' => 3500.00,
                'stock' => 50,
                'attributes' => ['size' => 'Pocket Size', 'description' => 'Compact 3x5 cards, perfect for travel & little hands.'],
            ]
        );

        $fc1_v2 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-FC-001-BIG'],
            [
                'product_id' => $fc1->id,
                'name' => 'Big Size',
                'price' => 5500.00,
                'stock' => 50,
                'attributes' => ['size' => 'Big Size', 'description' => 'Extra-large 5x7 high-contrast cards for home & group learning.'],
            ]
        );

        $fc2 = Product::updateOrCreate(
            ['sku' => 'PD-FC-002'],
            [
                'category_id' => $flashcards->id,
                'name' => 'Animals & Nature Flashcards',
                'slug' => 'animals-and-nature-flashcards',
                'price' => 3500.00,
                'stock_quantity' => 80,
                'description' => 'Colorful flashcards introducing children to wildlife, habitats, and nature facts. Choose between Pocket Size and Big Size.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        $fc2_v1 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-FC-002-PKT'],
            [
                'product_id' => $fc2->id,
                'name' => 'Pocket Size',
                'price' => 3500.00,
                'stock' => 40,
                'attributes' => ['size' => 'Pocket Size'],
            ]
        );

        $fc2_v2 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-FC-002-BIG'],
            [
                'product_id' => $fc2->id,
                'name' => 'Big Size',
                'price' => 5500.00,
                'stock' => 40,
                'attributes' => ['size' => 'Big Size'],
            ]
        );

        // 4. Products: JIGSAW PUZZLES (with Easy — 6 pieces & Intermediate — 12 pieces)
        $puz1 = Product::updateOrCreate(
            ['sku' => 'PD-PUZ-001'],
            [
                'category_id' => $puzzles->id,
                'name' => 'Safari Animal Kingdom Jigsaw Puzzle',
                'slug' => 'safari-animal-kingdom-jigsaw-puzzle',
                'price' => 4000.00,
                'stock_quantity' => 80,
                'description' => 'Vibrant, thick-board jigsaw puzzle featuring playful safari animals. Available in Easy (6 pieces) for toddlers and Intermediate (12 pieces) for growing problem-solvers.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        $puz1_v1 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-PUZ-001-E6'],
            [
                'product_id' => $puz1->id,
                'name' => 'Easy — 6 pieces',
                'price' => 4000.00,
                'stock' => 40,
                'attributes' => ['difficulty' => 'Easy', 'pieces' => 6],
            ]
        );

        $puz1_v2 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-PUZ-001-I12'],
            [
                'product_id' => $puz1->id,
                'name' => 'Intermediate — 12 pieces',
                'price' => 5500.00,
                'stock' => 40,
                'attributes' => ['difficulty' => 'Intermediate', 'pieces' => 12],
            ]
        );

        $puz2 = Product::updateOrCreate(
            ['sku' => 'PD-PUZ-002'],
            [
                'category_id' => $puzzles->id,
                'name' => 'Magical Space Galaxy Jigsaw Puzzle',
                'slug' => 'magical-space-galaxy-jigsaw-puzzle',
                'price' => 4000.00,
                'stock_quantity' => 60,
                'description' => 'Bright galactic jigsaw puzzle exploring rockets, planets, and constellations. Available in Easy (6 pieces) and Intermediate (12 pieces).',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        $puz2_v1 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-PUZ-002-E6'],
            [
                'product_id' => $puz2->id,
                'name' => 'Easy — 6 pieces',
                'price' => 4000.00,
                'stock' => 30,
                'attributes' => ['difficulty' => 'Easy', 'pieces' => 6],
            ]
        );

        $puz2_v2 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-PUZ-002-I12'],
            [
                'product_id' => $puz2->id,
                'name' => 'Intermediate — 12 pieces',
                'price' => 5500.00,
                'stock' => 30,
                'attributes' => ['difficulty' => 'Intermediate', 'pieces' => 12],
            ]
        );

        // 5. Products: COLORING BOOKS
        $col1 = Product::updateOrCreate(
            ['sku' => 'PD-COL-001'],
            [
                'category_id' => $colouring->id,
                'name' => 'My First World of Wonder Coloring Book',
                'slug' => 'my-first-world-of-wonder-coloring-book',
                'price' => 4000.00,
                'stock_quantity' => 60,
                'description' => 'Over 80 pages of thick, bleed-resistant paper filled with cheerful illustrations of animals, vehicles, and whimsical characters.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        $col2 = Product::updateOrCreate(
            ['sku' => 'PD-COL-002'],
            [
                'category_id' => $colouring->id,
                'name' => 'Super Kids Mindfulness & Doodle Coloring Book',
                'slug' => 'super-kids-mindfulness-doodle-book',
                'price' => 4500.00,
                'stock_quantity' => 40,
                'description' => 'Interactive doodle pages designed to promote relaxation, focus, and positive self-affirmations for growing children.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // 6. Products: STORYBOOKS
        $sb1 = Product::updateOrCreate(
            ['sku' => 'PD-STORY-001'],
            [
                'category_id' => $storyBooks->id,
                'name' => 'Adventures of the Little Explorer (Hardcover)',
                'slug' => 'adventures-of-the-little-explorer',
                'price' => 6500.00,
                'stock_quantity' => 50,
                'description' => 'Follow Leo on an enchanting bedtime adventure through magical forests. Full of lessons on courage, kindness, and friendship.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        $sb2 = Product::updateOrCreate(
            ['sku' => 'PD-STORY-002'],
            [
                'category_id' => $storyBooks->id,
                'name' => 'The Boy Who Spoke to the Stars',
                'slug' => 'the-boy-who-spoke-to-the-stars',
                'price' => 6000.00,
                'stock_quantity' => 45,
                'description' => 'A heartwarming tale about curiosity, space exploration, and dreaming big. Written by WrittenbyPD.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        $sb3 = Product::updateOrCreate(
            ['sku' => 'PD-STORY-003'],
            [
                'category_id' => $storyBooks->id,
                'name' => 'The Magic Garden of Courage',
                'slug' => 'the-magic-garden-of-courage',
                'price' => 7000.00,
                'stock_quantity' => 40,
                'description' => 'An uplifting storybook teaching young readers how to overcome fear and bloom with confidence.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );

        // 7. PRODUCT BUNDLES (Encourages purchasing multiple items & fulfills "Fill Your Box")
        // Bundle 1: 5-Item Starter Bundle
        // Combination: 2 Jigsaw Puzzles + 1 Coloring Book + 1 Flashcard + 1 Storybook = 5 items
        $bundle5 = Bundle::updateOrCreate(
            ['slug' => 'starter-learning-box-5-items'],
            [
                'name' => 'Starter Learning Box',
                'badge' => '5-Item Bundle • Popular',
                'price' => 20500.00,
                'original_price' => 24000.00,
                'description' => 'The ultimate starter package combining hands-on play and reading! Includes 2 Jigsaw Puzzles, 1 Coloring Book, 1 Flashcard set, and 1 Storybook.',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // Clean & sync bundle items
        $bundle5->items()->delete();
        BundleItem::create([
            'bundle_id' => $bundle5->id,
            'product_id' => $puz1->id,
            'product_variant_id' => $puz1_v1->id, // Safari Puzzle (Easy — 6 pieces)
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle5->id,
            'product_id' => $puz2->id,
            'product_variant_id' => $puz2_v2->id, // Space Puzzle (Intermediate — 12 pieces)
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle5->id,
            'product_id' => $col1->id, // My First World Coloring Book
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle5->id,
            'product_id' => $fc1->id,
            'product_variant_id' => $fc1_v1->id, // Everyday Words Flashcards (Pocket Size)
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle5->id,
            'product_id' => $sb1->id, // Adventures of the Little Explorer
            'quantity' => 1,
        ]);

        // Bundle 2: 10-Item Super Explorer Box
        // Combination: 3 Puzzles + 2 Flashcards + 2 Coloring Books + 3 Storybooks = 10 items
        $bundle10 = Bundle::updateOrCreate(
            ['slug' => 'ultimate-explorer-box-10-items'],
            [
                'name' => 'Ultimate Explorer Box',
                'badge' => '10-Item Bundle • Best Value',
                'price' => 41500.00,
                'original_price' => 50000.00,
                'description' => 'The comprehensive home learning box! Packed with 3 Jigsaw Puzzles, 2 Flashcard sets, 2 Coloring Books, and 3 inspiring Storybooks.',
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        $bundle10->items()->delete();
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $puz1->id,
            'product_variant_id' => $puz1_v1->id,
            'quantity' => 2, // 2x Safari Puzzle
        ]);
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $puz2->id,
            'product_variant_id' => $puz2_v2->id,
            'quantity' => 1, // 1x Space Puzzle
        ]);
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $fc1->id,
            'product_variant_id' => $fc1_v1->id,
            'quantity' => 1, // Everyday Words Flashcards
        ]);
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $fc2->id,
            'product_variant_id' => $fc2_v2->id,
            'quantity' => 1, // Animals Flashcards (Big Size)
        ]);
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $col1->id,
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $col2->id,
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $sb1->id,
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $sb2->id,
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $sb3->id,
            'quantity' => 1,
        ]);

        // 8. Seed Customer Reviews
        Review::updateOrCreate(
            ['product_id' => $sb1->id, 'customer_name' => 'Mrs. Folake K. (Lagos)'],
            [
                'rating' => 5,
                'comment' => 'My 6-year-old daughter absolutely loves bedtime story reading with this book! Delivery to Lekki took only 24 hours.',
            ]
        );

        Review::updateOrCreate(
            ['product_id' => $puz1->id, 'customer_name' => 'Mr. Chidi O. (Abuja)'],
            [
                'rating' => 5,
                'comment' => 'High quality puzzle pieces that do not tear easily. The 6-piece easy version is perfect for my 3-year-old!',
            ]
        );

        // 9. Seed Coupons
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
