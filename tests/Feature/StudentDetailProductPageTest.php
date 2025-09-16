<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class StudentDetailProductPageTest extends TestCase
{
    /**
     * Test if the view has required data.
     */
    public function test_if_the_view_has_required_data(): void
    {
        $response = $this->get(route('student.detail-product', Product::query()->inRandomOrder()->first()));

        $response->assertStatus(200);
        $response->assertViewHasAll([
            'product' => function (Product $product) {
                $this->assertInstanceOf(Product::class, $product);
                return true;
            },
            'recommendedProducts' => function (Collection $products) {
                foreach ($products as $product) {
                    $this->assertInstanceOf(Product::class, $product);
                }
                return true;
            },
        ]);
    }
}
