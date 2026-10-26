<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
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

        // Helper function to sync product images
        $syncImages = function (Product $product, array $imagePaths) {
            ProductImage::where('product_id', $product->id)->delete();
            foreach ($imagePaths as $index => $path) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => ($index === 0),
                    'sort_order' => $index,
                ]);
            }
        };

        // 3. Products: FLASHCARDS
        // Real Product 1: Affirmations! Flashcards by Pelumi Dada
        $fc1 = Product::updateOrCreate(
            ['sku' => 'PD-FC-001'],
            [
                'category_id' => $flashcards->id,
                'name' => 'Affirmations! Flashcards',
                'slug' => 'affirmations-flashcards',
                'price' => 3500.00,
                'stock_quantity' => 100,
                'description' => 'Inspiring biblical affirmation flashcards by Pelumi Dada, illustrated by Jennifer Sado. Includes 20 colorful, durable cards with positive declarations and scripture themes to build confidence in young minds.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );
        $syncImages($fc1, ['products/affirmations_flashcards_cover.jpg']);

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

        // Flashcards 2: Everyday Words & Numbers Flashcards
        $fc2 = Product::updateOrCreate(
            ['sku' => 'PD-FC-002'],
            [
                'category_id' => $flashcards->id,
                'name' => 'Everyday Words & Numbers Flashcards',
                'slug' => 'everyday-words-and-numbers-flashcards',
                'price' => 3500.00,
                'stock_quantity' => 80,
                'description' => 'Educational flashcards covering everyday vocabulary, numbers, and basic phonics. Available in convenient Pocket Size for on-the-go learning and Big Size for tabletop interactive play.',
                'is_featured' => false,
                'is_active' => true,
            ]
        );
        $syncImages($fc2, ['products/affirmations_flashcards_cover.jpg']);

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

        // 4. Products: COLORING BOOKS
        // Real Product 1: Light Series Colouring Book
        $col1 = Product::updateOrCreate(
            ['sku' => 'PD-COL-001'],
            [
                'category_id' => $colouring->id,
                'name' => 'Light Series Colouring Book',
                'slug' => 'light-series-colouring-book',
                'price' => 4000.00,
                'stock_quantity' => 60,
                'description' => 'Engaging and inspirational colouring book from the Light Series by Pelumi Dada, illustrated by Jennifer Sado. Filled with cheerful illustrations celebrating faith, friendship, and childhood creativity on high-grade paper.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );
        $syncImages($col1, ['products/light_series_colouring_book_cover.jpg']);

        // Real Product 2: Psalm 23 Colouring Book
        $col2 = Product::updateOrCreate(
            ['sku' => 'PD-COL-002'],
            [
                'category_id' => $colouring->id,
                'name' => 'Psalm 23 Colouring Book',
                'slug' => 'psalm-23-colouring-book',
                'price' => 4000.00,
                'stock_quantity' => 60,
                'description' => 'Delightful faith-filled colouring book by Pelumi Dada, illustrated by Jennifer Sado. Walks children through the comforting promises of Psalm 23 with playful, beautifully illustrated scenes to color.',
                'is_featured' => true,
                'is_active' => true,
            ]
        );
        $syncImages($col2, ['products/psalm_23_colouring_book_cover.jpg']);

        // 5. Products: JIGSAW PUZZLES (With Easy — 6 pieces & Intermediate — 12 pieces)
        // Puzzle 1: Give Thanks (Psalm 107:1) Jigsaw Puzzle
        $puz1 = Product::updateOrCreate(
            ['sku' => 'PD-PUZ-001'],
            [
                'category_id' => $puzzles->id,
                'name' => 'Give Thanks (Psalm 107:1) Jigsaw Puzzle',
                'slug' => 'give-thanks-psalm-107-jigsaw-puzzle',
                'price' => 4000.00,
                'stock_quantity' => 80,
                'description' => "Vibrant jigsaw puzzle featuring Kiki celebrating God's goodness with Psalm 107:1 ('Oh, give thanks to the Lord, for He is good... His steadfast love endures forever'). Made with durable, thick-board child-safe pieces.",
                'is_featured' => true,
                'is_active' => true,
            ]
        );
        $syncImages($puz1, [
            'products/easy_puzzle_1_cover.jpg',
            'products/easy_puzzle_1_cut.jpg',
        ]);

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

        // Puzzle 2: Rejoice Always (Philippians 4:4) Ballerina Jigsaw Puzzle
        $puz2 = Product::updateOrCreate(
            ['sku' => 'PD-PUZ-002'],
            [
                'category_id' => $puzzles->id,
                'name' => 'Rejoice Always (Philippians 4:4) Ballerina Jigsaw Puzzle',
                'slug' => 'rejoice-always-philippians-4-jigsaw-puzzle',
                'price' => 4000.00,
                'stock_quantity' => 80,
                'description' => "Enchanting ballerina jigsaw puzzle inspired by Philippians 4:4 ('Rejoice in the Lord always. I will say it again: rejoice!'). Designed to inspire joy, confidence, and fine motor problem-solving.",
                'is_featured' => true,
                'is_active' => true,
            ]
        );
        $syncImages($puz2, [
            'products/easy_puzzle_2_cover.jpg',
            'products/easy_puzzle_2_cut.jpg',
        ]);

        $puz2_v1 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-PUZ-002-E6'],
            [
                'product_id' => $puz2->id,
                'name' => 'Easy — 6 pieces',
                'price' => 4000.00,
                'stock' => 40,
                'attributes' => ['difficulty' => 'Easy', 'pieces' => 6],
            ]
        );

        $puz2_v2 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-PUZ-002-I12'],
            [
                'product_id' => $puz2->id,
                'name' => 'Intermediate — 12 pieces',
                'price' => 5500.00,
                'stock' => 40,
                'attributes' => ['difficulty' => 'Intermediate', 'pieces' => 12],
            ]
        );

        // Puzzle 3: Enduring Love (1 Chronicles 16:34) Jigsaw Puzzle
        $puz3 = Product::updateOrCreate(
            ['sku' => 'PD-PUZ-003'],
            [
                'category_id' => $puzzles->id,
                'name' => 'Enduring Love (1 Chronicles 16:34) Jigsaw Puzzle',
                'slug' => 'enduring-love-1-chronicles-jigsaw-puzzle',
                'price' => 4000.00,
                'stock_quantity' => 70,
                'description' => "Joyful outdoor meadow scene with Kiki, her brother, and puppy celebrating 1 Chronicles 16:34 ('Give thanks to the Lord, for He is good... His love endures forever').",
                'is_featured' => true,
                'is_active' => true,
            ]
        );
        $syncImages($puz3, [
            'products/easy_puzzle_3_cover.jpg',
            'products/easy_puzzle_3_cut.jpg',
        ]);

        $puz3_v1 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-PUZ-003-E6'],
            [
                'product_id' => $puz3->id,
                'name' => 'Easy — 6 pieces',
                'price' => 4000.00,
                'stock' => 35,
                'attributes' => ['difficulty' => 'Easy', 'pieces' => 6],
            ]
        );

        $puz3_v2 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-PUZ-003-I12'],
            [
                'product_id' => $puz3->id,
                'name' => 'Intermediate — 12 pieces',
                'price' => 5500.00,
                'stock' => 35,
                'attributes' => ['difficulty' => 'Intermediate', 'pieces' => 12],
            ]
        );

        // Puzzle 4: Pray Continually (1 Thessalonians 5:16-18) Jigsaw Puzzle
        $puz4 = Product::updateOrCreate(
            ['sku' => 'PD-PUZ-004'],
            [
                'category_id' => $puzzles->id,
                'name' => 'Pray Continually (1 Thessalonians 5:16-18) Jigsaw Puzzle',
                'slug' => 'pray-continually-1-thessalonians-jigsaw-puzzle',
                'price' => 4000.00,
                'stock_quantity' => 60,
                'description' => "Heartwarming jigsaw puzzle featuring children joining hands in prayer with 1 Thessalonians 5:16-18 ('Rejoice always, pray continually, give thanks in all circumstances').",
                'is_featured' => true,
                'is_active' => true,
            ]
        );
        $syncImages($puz4, [
            'products/intermediate_puzzle_1_cover.jpg',
            'products/intermediate_puzzle_1_cut.jpg',
        ]);

        $puz4_v1 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-PUZ-004-E6'],
            [
                'product_id' => $puz4->id,
                'name' => 'Easy — 6 pieces',
                'price' => 4000.00,
                'stock' => 30,
                'attributes' => ['difficulty' => 'Easy', 'pieces' => 6],
            ]
        );

        $puz4_v2 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-PUZ-004-I12'],
            [
                'product_id' => $puz4->id,
                'name' => 'Intermediate — 12 pieces',
                'price' => 5500.00,
                'stock' => 30,
                'attributes' => ['difficulty' => 'Intermediate', 'pieces' => 12],
            ]
        );

        // Puzzle 5: Strength & Shield (Psalms 28:7) Jigsaw Puzzle
        $puz5 = Product::updateOrCreate(
            ['sku' => 'PD-PUZ-005'],
            [
                'category_id' => $puzzles->id,
                'name' => 'Strength & Shield (Psalms 28:7) Jigsaw Puzzle',
                'slug' => 'strength-and-shield-psalms-28-jigsaw-puzzle',
                'price' => 4000.00,
                'stock_quantity' => 60,
                'description' => "Inspiring biblical jigsaw puzzle depicting a young champion with a golden shield illustrating Psalms 28:7 ('The Lord is my strength and my shield; my heart trusts in Him, and He helps me').",
                'is_featured' => true,
                'is_active' => true,
            ]
        );
        $syncImages($puz5, [
            'products/intermediate_puzzle_2_cover.jpg',
        ]);

        $puz5_v1 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-PUZ-005-E6'],
            [
                'product_id' => $puz5->id,
                'name' => 'Easy — 6 pieces',
                'price' => 4000.00,
                'stock' => 30,
                'attributes' => ['difficulty' => 'Easy', 'pieces' => 6],
            ]
        );

        $puz5_v2 = ProductVariant::updateOrCreate(
            ['sku' => 'PD-PUZ-005-I12'],
            [
                'product_id' => $puz5->id,
                'name' => 'Intermediate — 12 pieces',
                'price' => 5500.00,
                'stock' => 30,
                'attributes' => ['difficulty' => 'Intermediate', 'pieces' => 12],
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

        // 7. PRODUCT BUNDLES (Positioned around curated combinations and convenience)
        // Bundle 1: 5-Item Starter Bundle
        $bundle5 = Bundle::updateOrCreate(
            ['slug' => 'starter-learning-box-5-items'],
            [
                'name' => 'Starter Learning Box',
                'badge' => '5-Item Bundle • Curated Set',
                'price' => 20500.00,
                'original_price' => 20500.00,
                'description' => 'The ultimate starter package combining hands-on play and reading! Includes 2 Jigsaw Puzzles, 1 Coloring Book, 1 Flashcard set, and 1 Storybook.',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        $bundle5->items()->delete();
        BundleItem::create([
            'bundle_id' => $bundle5->id,
            'product_id' => $puz1->id,
            'product_variant_id' => $puz1_v1->id, // Give Thanks (Easy — 6 pieces)
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle5->id,
            'product_id' => $puz2->id,
            'product_variant_id' => $puz2_v2->id, // Rejoice Ballerina (Intermediate — 12 pieces)
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle5->id,
            'product_id' => $col1->id, // Light Series Colouring Book
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle5->id,
            'product_id' => $fc1->id,
            'product_variant_id' => $fc1_v1->id, // Affirmations Flashcards (Pocket Size)
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle5->id,
            'product_id' => $sb1->id, // Adventures of the Little Explorer
            'quantity' => 1,
        ]);

        // Bundle 2: 10-Item Ultimate Explorer Box
        $bundle10 = Bundle::updateOrCreate(
            ['slug' => 'ultimate-explorer-box-10-items'],
            [
                'name' => 'Ultimate Explorer Box',
                'badge' => '10-Item Bundle • Curated Set',
                'price' => 41500.00,
                'original_price' => 41500.00,
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
            'quantity' => 1, // Give Thanks
        ]);
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $puz2->id,
            'product_variant_id' => $puz2_v2->id,
            'quantity' => 1, // Rejoice Ballerina
        ]);
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $puz3->id,
            'product_variant_id' => $puz3_v1->id,
            'quantity' => 1, // Enduring Love
        ]);
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $fc1->id,
            'product_variant_id' => $fc1_v1->id, // Affirmations (Pocket Size)
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $fc1->id,
            'product_variant_id' => $fc1_v2->id, // Affirmations (Big Size)
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $col1->id, // Light Series
            'quantity' => 1,
        ]);
        BundleItem::create([
            'bundle_id' => $bundle10->id,
            'product_id' => $col2->id, // Psalm 23
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

        // 8. Seed Customer Reviews with Ratings & Comments
        Review::updateOrCreate(
            ['product_id' => $fc1->id, 'customer_name' => 'Mrs. Adebayo (Lekki)'],
            [
                'rating' => 5,
                'comment' => 'The Affirmations flashcards are exceptional! My 5-year-old recites them every morning before school. Truly uplifting and beautifully illustrated.',
                'is_approved' => true,
            ]
        );

        Review::updateOrCreate(
            ['product_id' => $puz1->id, 'customer_name' => 'Pastor Chidi O. (Abuja)'],
            [
                'rating' => 5,
                'comment' => 'High quality puzzle pieces that do not tear or bend easily. The Psalm 107:1 scripture makes puzzle time meaningful for our children!',
                'is_approved' => true,
            ]
        );

        Review::updateOrCreate(
            ['product_id' => $puz2->id, 'customer_name' => 'Dr. Ngozi E. (Ikeja)'],
            [
                'rating' => 5,
                'comment' => 'My daughter was thrilled with the ballerina puzzle! The colors are so bright and joyous. Will definitely be getting the full set.',
                'is_approved' => true,
            ]
        );

        Review::updateOrCreate(
            ['product_id' => $col2->id, 'customer_name' => 'Mrs. Folake K. (Victoria Island)'],
            [
                'rating' => 5,
                'comment' => 'The Psalm 23 coloring book has become our family favourite! Thick pages that do not bleed with markers, and lovely illustrations.',
                'is_approved' => true,
            ]
        );

        Review::updateOrCreate(
            ['product_id' => $sb1->id, 'customer_name' => 'Kemi T. (Yaba)'],
            [
                'rating' => 5,
                'comment' => 'Enchanting bedtime story reading with this book! Delivery took only 24 hours in Lagos. Great packaging too.',
                'is_approved' => true,
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
