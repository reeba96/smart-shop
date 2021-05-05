<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;

class ImportNow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ImportNow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'You can easily import your data set from csv file to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Create fake customers
        // for ($i=1; $i <10 ; $i++) {

        //     $r = $i * 1001;
        //     echo "Eddig $r felhasznalo keszult el. ";
        // }

        // $user = factory(
        //     \Webkul\Customer\Models\Customer::class,
        //     1050
        // )->create();

        //--------------------------------------------------------------------------------------

        // Feed categories
        // $now = Carbon::now();
        // $rowCategory = 1;
        // $rowCategoryId = 1;

        // if (($category = fopen("storage/app/categories.csv", "r")) !== FALSE) {
        //     $lft = 10;
        //     while (($data = fgetcsv($category, 500)) !== FALSE) {
        //         $num = count($data);

        //         if ($rowCategory > 1) {
        //             echo $data[0];
        //             $position = random_int(1 , 20);
        //             DB::table('categories')->insertOrIgnore([
        //                 // 'id' => $data[0],
        //                 'position' => $position,
        //                 'status' => 1,
        //                 'created_at' => $now,
        //                 'updated_at' => $now,
        //                 'parent_id' => 1,
        //                 '_lft' => $lft,
        //                 '_rgt' => $lft + 1,
        //             ]);

        //             $lft = $lft + 2;

        //             $slugandurl_path = strtolower($data[1]);
        //             // $str = 'Kiskutya feje';
        //             // $findme = ' ';
        //             // $pos = strpos($str, ' ');
        //             if (str_contains($slugandurl_path, ' ')) {
        //                 $slugandurl_path = str_replace(' ', '-', $slugandurl_path);
        //             };
        //             echo $slugandurl_path;
        //             try {
        //                 DB::table('category_translations')->insertOrIgnore([
        //                     'category_id' => $rowCategoryId,
        //                     'name' => ucfirst($data[1]),
        //                     'description' => ucfirst($data[1]),
        //                     'slug' => $slugandurl_path,
        //                     'locale' => 'en',
        //                     'meta_title' => '',
        //                     'meta_description' => '',
        //                     'meta_keywords' => '',
        //                     'url_path' => $slugandurl_path,
        //                     'locale_id' => 1,

        //                 ]);
        //             } catch (\Exception $e) {
        //                 error_log('ERRRRROOOORRRR');
        //                 \Log::error($e);

        //             }

        //         }

        //         $rowCategory++;
        //         $rowCategoryId++;

        //     }

        //     DB::table('categories')->where('id', 1)->update([
        //         '_rgt' => $lft,
        //     ]);

        //     fclose($category);

        // }

        //-----------------------------------------------------------------------------------------

        //Feed and connect products to the other tables

        // $aisleArray = array();
        // $rowAisle = 1;

        // if (($aisle = fopen("storage/app/aisles.csv", "r")) !== FALSE) {
        //     while (($data = fgetcsv($aisle, 500)) !== FALSE) {
        //         $num = count($data);
        //         if ($rowAisle > 1) {
        //             $aisleArray[$data[0]] = $data[1];
        //         }
        //         $rowAisle++;
        //     }
        //     fclose($aisle);
        // }
        // dd('szia');
        // $sku = 11111111;
        // $rowProduct = 1;

        // if (($handle = fopen("storage/app/productTest.csv", "r")) !== FALSE) {
        //     while (($data = fgetcsv($handle, 500)) !== FALSE) {
        //         $num = count($data);
        //         // dd($data);
        //         echo "$num fields in line $data[0], name: $data[1],departman_id: $data[3],   \n";
        //         if ($rowProduct > 1) {
        //             $now = Carbon::now();
        //             // dd($data[0]);
        //             DB::table('products')->insertOrIgnore([
        //                 'id' => $data[0],

        //                 'sku' => $sku,
        //                 'created_at' => $now,
        //                 'updated_at' => $now,
        //                 'attribute_family_id' => 1,
        //                 'type' => 'simple',
        //             ]);
        //             $dep_id = trim($data[3]);
        //             echo $data[3] . "\n";
        //             DB::table('product_categories')->insertOrIgnore([
        //                 'product_id' => $data[0],
        //                 'category_id' => $dep_id + 1,
        //             ]);

        //             $aisleDescription = "<p>" . $aisleArray[$data[3]] . "</p>";
        //             $url_key = strtolower(str_replace(" ", "-", $data[1]));
        //             $price = random_int(1 , 50);
        //             $weight = random_int(1 , 10);

        //             DB::table('product_flat')->insertOrIgnore([
        //                 'product_id' => $data[0],
        //                 'name' => $data[1],
        //                 'description' => $aisleDescription,
        //                 'short_description' => 'short description',
        //                 'sku' => $sku,
        //                 'url_key' => $url_key,
        //                 'price' => $price,
        //                 'min_price' => $price,
        //                 'max_price' => $price,
        //                 'weight' => $weight,
        //                 'new' => 0,
        //                 'status' => 1,
        //                 'locale' => 'en',
        //                 'visible_individually' => 1,
        //                 'channel' => 'default',
        //                 'featured' => 0,
        //                 'created_at' => $now,
        //                 'updated_at' => $now,
        //             ]);

        //             DB::table('product_inventories')->insertOrIgnore([
        //                 'product_id' => $data[0],

        //                 'qty' => 10,
        //                 'inventory_source_id' => 1,
        //                 'vendor_id' => 0,
        //             ]);

        //             $sku++;
        //         }
        //         $rowProduct++;

        //     }
        //     fclose($handle);
        // }

        //-----------------------------------------------------------------------

        // $rowProduct = 1;
        // if (($handle = fopen("storage/app/productTest.csv", "r")) !== FALSE) {
        //         while (($data = fgetcsv($handle, 500)) !== FALSE) {
        //             $num = count($data);
        //             // dd($data);
        //             echo "$num fields in line, product id:  $data[0], name: $data[1],departman_id: $data[3],   \n";
        //             if ($rowProduct > 1) {

        //                 $dep_id = trim($data[3]);
        //                 echo $data[3] . "\n";
        //                 DB::table('product_categories')->insertOrIgnore([
        //                     'product_id' => $data[0],
        //                     'category_id' => $dep_id + 1,
        //                 ]);

        //             }
        //             $rowProduct++;

        //         }
        //         fclose($handle);
        //     }

        //-----------------------------------------------------------------------------------------

        // Feed product attributes values

        // $attributes = DB::table('product_flat')->get();

        // foreach ($attributes as $attribute) {

        //     $id = $attribute -> id;

        //     $sku = $attribute -> sku;
        //     $name = $attribute -> name;
        //     $url_key = $attribute -> url_key;
        //     $new = $attribute -> new;
        //     $visible_individually = $attribute -> visible_individually;
        //     $status = $attribute -> status;
        //     $short_description = $attribute -> short_description;
        //     $description = $attribute -> description;
        //     $price = $attribute -> price;
        //     $weight = $attribute -> weight;
        //     $boolean = null;
        //     // echo "\n" .  $id . " " . $name . " " . $url_key . " " . $new;

        //     $attributes_id = array(1 => 'sku', 2 => 'name', 3 => 'url_key', 5 => 'new', 7 => 'visible_individually', 8 => 'status', 9 => 'short_description', 10 => 'description', 11 => 'price', 22 => 'weight');

        //     foreach ($attributes_id as $key => $value) {
        //         echo $id . ' ' . $key . '=' . $value . "\n";
        //         $float = '';
        //         switch ($key) {
        //             case 1:
        //                 $text = $sku;
        //                 break;
        //             case 2:
        //                 $text = $name;
        //                 break;
        //             case 3:
        //                 $text = $url_key;
        //                 break;
        //             case 5:
        //                 $text = $new;
        //                 break;
        //             case 7:
        //                 $text = null;
        //                 $boolean = 1;
        //                 break;
        //             case 8:
        //                 $text = null;
        //                 $boolean = 1;
        //                 break;
        //             case 9:
        //                 $text = $short_description;
        //                 break;
        //             case 10:
        //                 $text = $description;
        //                 break;
        //             case 11:
        //                 $text = '';
        //                 $float = $price;
        //                 break;
        //             case 22:
        //                 $text = $weight;
        //                 break;
        //             default:
        //                 $text = 'missing';
        //                 break;
        //         }

        //         DB::table('product_attribute_values')->insertOrIgnore([

        //             'product_id' => $id,
        //             'attribute_id' => $key,
        //             'text_value' => $text,
        //             'locale' => 'en',
        //             'channel' => 'default',
        //             'integer_value' => 1,
        //             'boolean_value' => 0,
        //             'float_value' => $float,
        //             'boolean_value' => $boolean,

        //         ]);

        //     }

        // }

        // ----------------------------------------------------------------------------------------------------

        // Feed orders

        // $rowProduct = 1;
        // $increment_id = 1;
        // if (($handle = fopen("storage/app/ordersTest.csv", "r")) !== FALSE) {
        //     while (($data = fgetcsv($handle, 500)) !== FALSE) {
        //         $num = count($data);

        //         if ($rowProduct > 1) {

        //             // echo "$data[0], id: $data[1] \n";

        //             $attr = DB::table('customers')->where('id', $data[1])->get();
        //             // echo $attr;

        //             foreach ($attr as $attribute) {

        //                 // $customer_id = $attribute -> id;
        //                 $firstName = $attribute -> first_name;
        //                 $lastName = $attribute -> last_name;
        //                 $email = $attribute -> email;

        //             }
        //             echo "fname: $firstName, lname: $lastName, email: $email";

        //             $attributes = DB::table('product_flat')->where('id', $data[1])->get();

        //             foreach ($attributes as $attribute) {

        //                 $id = $attribute -> id;
        //                 $price = $attribute -> price;
        //                 $name = $attribute -> name;
        //             }
        //             echo "field: $num, id: $id, price: $price, name: $name \n";
        //             $now = Carbon::now();

        //             DB::table('orders')->insertOrIgnore([
        //                 'id' => $increment_id,
        //                 'increment_id' => $increment_id,
        //                 'status' => 'completed',
        //                 'channel_name' => 'Default',
        //                 'is_guest' => 0,
        //                 'customer_email' => $email,
        //                 'customer_first_name' => $firstName,
        //                 'customer_last_name' => $lastName,
        //                 'shipping_method' => 'free_free',
        //                 'shipping_title' => 'Free Shipping - Free Shipping',
        //                 'shipping_description' => 'Free Shipping',
        //                 'is_gift' => 0,
        //                 'total_item_count' => 1,
        //                 'total_qty_ordered' => 1,
        //                 'base_currency_code' => 'EUR',
        //                 'channel_currency_code' => 'USD',
        //                 'order_currency_code' => 'USD',
        //                 // 'grand_total' => $price,
        //                 // 'base_grand_total' => $price,
        //                 // 'grand_total_invoiced' => $price,
        //                 // 'base_grand_total_invoiced' => $price,
        //                 // 'grand_total_refunded' => 0,
        //                 // 'base_grand_total_refunded' => 0,
        //                 // 'sub_total' => $price,
        //                 // 'base_sub_total' => $price,
        //                 // 'sub_total_invoiced' => $price,
        //                 // 'base_sub_total_invoiced' => $price,
        //                 'customer_id' => $data[1],
        //                 'customer_type' => 'Webkul\Customer\Models\Customer',
        //                 'channel_id' => 1,
        //                 'channel_type' => 'Webkul\Core\Models\Channel',
        //                 'created_at' => $now,
        //                 'updated_at' => $now,
        //                 'cart_id' => $increment_id,

        //             ]);

        //             $increment_id++;

        //         }
        //         $rowProduct++;

        //     }
        //     fclose($handle);
        // }

        // // Feed orders

        $rowProduct = 1;
        $increment_id = 1;
        if (($handle = fopen("storage/app/order_products__prior.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 500)) !== FALSE) {
                $num = count($data);
                echo "$num fields in line $data[0], name: $data[1],departman_id: $data[3],   \n";

                if ($rowProduct > 1) {
                    // dd($data[1]);
                    $attributes = DB::table('product_flat')->where('product_id', $data[1])->get();
                    // dd($attributes);

                    foreach ($attributes as $attribute) {

                        $sku = $attribute -> sku;
                        $name = $attribute -> name;
                        $price = $attribute -> price;
                        $weight = $attribute -> weight;

                    }

                    echo "sku $sku, name: $name, price: $price, weight: $weight \n";
                    $now = Carbon::now();

                    DB::table('order_items')->insertOrIgnore([
                        'product_id' => $data[1],
                        'sku' => $sku,
                        'type' => 'simple',
                        'name' => $name,
                        'weight' => $weight,
                        'total_weight' => $weight,
                        'qty_ordered' => 1,
                        'qty_shipped' => 1,
                        'qty_invoiced' => 1,
                        'price' => $price,
                        'total' => $price,
                        'base_total' => $price,
                        'base_price' => $price,
                        'total_invoiced' => $price,
                        'base_total_invoiced' => $price,
                        'product_type' => 'Webkul\Product\Models\Product',
                        'order_id' => $data[0],
                        'additional' => '{"_token": "1221"}',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);

                    $increment_id++;

                }
                $rowProduct++;

            }
            fclose($handle);
        }
    }
}
