<?php

namespace Database\Seeders;

use App\Models\Variant;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VariantAttributeSeeder extends Seeder
{
   /**
     * Seed the variants_attributes table by assigning random attribute values
     * to each variant.
     *
     * This method retrieves all the variants and attribute values from the database
     * and randomly assigns between 1 and 3 attribute values to each variant. It then
     * inserts the relationships into the `variants_attributes` pivot table.
     *
     * @return void
    */
    public function run(): void
    {
        
        $variants = Variant::all();
        $attributeValues = AttributeValue::all();

        
        foreach ($variants as $variant) {
            $randomAttributeValues = $attributeValues->random(rand(1, 3)); 

            foreach ($randomAttributeValues as $attributeValue) {
                DB::table('variants_attributes')->insert([
                    'variant_id' => $variant->id,
                    'attribute_value_id' => $attributeValue->id,
                ]);
            }
        }
    }
}
