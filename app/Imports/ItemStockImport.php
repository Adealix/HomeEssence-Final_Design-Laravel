<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Item;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class ItemStockImport implements ToCollection, WithHeadingRow
{
    /**
     * Process the collection of rows from the imported Excel file.
     *
     * @param  \Illuminate\Support\Collection  $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Create a new Item record
            $item = Item::create([
                'name'        => $row['name'],          // Maps to the "name" column in your Excel file
                'description' => $row['description'],   // Maps to the "description" column
                'category'    => $row['category'],      // Maps to the "category" column
                'cost_price'  => $row['cost_price'],    // Maps to the "cost_price" column
                'sell_price'  => $row['sell_price'],    // Maps to the "sell_price" column
            ]);
            
            // Create a new Stock record for the item
            $stock = new Stock();
            $stock->item_id = $item->item_id;
            $stock->quantity = $row['quantity']; // Maps to the "quantity" column
            $stock->save();
            
                // Insert a default image record into the product_images table
                DB::table('product_images')->insert([
                 'item_id'    => $item->item_id,
                 'image_path' => 'default_picture.jpg',  // Ensure this matches your default path elsewhere
                 'created_at' => now(),
                 'updated_at' => now(),
                ]);
        }
    }
}
