<?php

use Illuminate\Database\Seeder;
use App\Cart;
use App\Category;
use App\CategoryProduct;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\ProductPicture;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        /***** CLEAR *****/
        Cart::truncate();
        OrderProduct::truncate();
        Order::truncate();
        CategoryProduct::truncate();
        Category::truncate();
        ProductPicture::truncate();
        Product::truncate();

        User::where('email','guest@example.com')->delete();
    	User::where('email','admin@example.com')->delete();

        /***** User *****/
    	$guest = User::create([
    		'name' => 'guest',
    		'email' => 'guest@example.com',
    		'password' => bcrypt('password')
    	]);

    	$admin = User::create([
    		'name' => 'admin',
    		'role' => 'OPERATION_MANAGER',
    		'email' => 'admin@example.com',
    		'password' => bcrypt('password')
    	]);

        /***** Category *****/
        $coffee = Category::create(['name' => 'coffee']);
        $powder = Category::create(['name' => 'powder', 'parent_id' => $coffee->id]);
        $beans = Category::create(['name' => 'beans', 'parent_id' => $coffee->id]);
        $arabica = Category::create(['name' => 'arabica', 'parent_id' => $beans->id]);
        $robusta = Category::create(['name' => 'robusta', 'parent_id' => $beans->id]);
        $tea = Category::create(['name' => 'tea']);

        /***** Product & PrductPicture *****/
        $nestle_black_tea = Product::create([
            'name' => 'Nestle Black Tea',
            'description' => 'Our favorite black tea. Good for your health.',
            'stock' => 100,
            'price' => 30000,
            'weight' => 0.2
        ]);

        $nestle_black_tea_pictures = 'nestle_black_tea.jpg';
        $picture = ProductPicture::create(['product_id' => $nestle_black_tea->id, 'filepath' => $nestle_black_tea_pictures]);
        $nestle_black_tea->product_pictures()->save($picture);

        $silver = Product::create([
            'name' => 'Silver Package (Powder)',
            'description' => 'Includes: 2x Coffee Powder',
            'stock' => 100,
            'price' => 50000,
            'weight' => 0.3
        ]);

        $silver_pictures = ['silver_1.jpg', 'silver_2.jpg', 'silver_3.jpg'];
        foreach ($silver_pictures as $filename){
            $picture = ProductPicture::create(['product_id' => $silver->id, 'filepath' => $filename]);
            $silver->product_pictures()->save($picture);
        }

        $gold = Product::create([
            'name' => 'Gold Package (Arabica Beans + Powder)',
            'description' => 'Includes: 1x Arabica Coffee Beans, 1x Coffee Powder',
            'stock' => 100,
            'price' => 90000,
            'weight' => 0.5
        ]);

        $gold_pictures = 'gold.jpg';
        $picture = ProductPicture::create(['product_id' => $gold->id, 'filepath' => $gold_pictures]);
        $gold->product_pictures()->save($picture);
        
        $platinum = Product::create([
            'name' => 'Platinum Package (Arabica Beans + Robusta Beans + Powder + Tea)',
            'description' => 'Includes: 1x Arabica Coffee Beans, 1x Robusta Coffee Beans, 1x Coffee Powder, 1x Tea',
            'stock' => 100,
            'price' => 135000,
            'weight' => 1
        ]);

        $platinum_pictures = ['platinum_1.jpg', 'platinum_2.jpg'];
        foreach ($platinum_pictures as $filename){
            $picture = ProductPicture::create(['product_id' => $platinum->id, 'filepath' => $filename]);
            $platinum->product_pictures()->save($picture);
        }

        /***** CategoryProduct *****/
        $category_1 = CategoryProduct::create(['category_id' => $tea->id, 'product_id' => $nestle_black_tea->id]);
        $category_2 = CategoryProduct::create(['category_id' => $coffee->id, 'product_id' => $silver->id]);
        $category_3 = CategoryProduct::create(['category_id' => $powder->id, 'product_id' => $silver->id]);
        $category_4 = CategoryProduct::create(['category_id' => $coffee->id, 'product_id' => $gold->id]);
        $category_5 = CategoryProduct::create(['category_id' => $powder->id, 'product_id' => $gold->id]);
        $category_6 = CategoryProduct::create(['category_id' => $beans->id, 'product_id' => $gold->id]);
        $category_7 = CategoryProduct::create(['category_id' => $tea->id, 'product_id' => $platinum->id]);
        $category_8 = CategoryProduct::create(['category_id' => $coffee->id, 'product_id' => $platinum->id]);
        $category_9 = CategoryProduct::create(['category_id' => $beans->id, 'product_id' => $platinum->id]);
        $category_10 = CategoryProduct::create(['category_id' => $powder->id, 'product_id' => $platinum->id]);

        /***** Cart *****/
        $cart_1 = Cart::create(['user_id' => $guest->id, 'product_id' => $platinum->id, 'quantity' => 3]);
        $cart_2 = Cart::create(['user_id' => $guest->id, 'product_id' => $nestle_black_tea->id, 'quantity' => 1]);
        $cart_3 = Cart::create(['user_id' => $admin->id, 'product_id' => $nestle_black_tea->id, 'quantity' => 3]);

        /***** Order & OrderProduct *****/
        $order_1 = Order::create(['status' => 'PENDING', 'user_id' => $guest->id, 'address' => 'Jl. Merdeka no. 17, 19']);
        $order_product_1 = OrderProduct::create(['order_id' => $order_1->id, 'product_id' => $silver->id, 'quantity' => 2, 'sum_price' => $silver->price * 2, 'sum_weight' => $silver->weight * 2]);
        $order_1->order_products()->save($order_product_1);
        $order_product_2 = OrderProduct::create(['order_id' => $order_1->id, 'product_id' => $gold->id, 'quantity' => 3, 'sum_price' => $gold->price * 3, 'sum_weight' => $silver->weight * 3]);
        $order_1->order_products()->save($order_product_2);

        $op = $order_1->order_products();
        $sum_price = 0;
        $sum_weight = 0;
        foreach ($op as $p){
            $sum_price += $p->sum_price;
            $sum_weight += $p->sum_weight;
        }
        $shipping_fee = $sum_weight * 5000;
        $unique_id = 123;
        $order_1->update([
            'sum_price' => $sum_price,
            'sum_weight' => $sum_weight,
            'shipping_fee' => $shipping_fee,
            'unique_id' => $unique_id,
            'amount' => $sum_price + $shipping_fee - $unique_id,
        ]);
    }
}
