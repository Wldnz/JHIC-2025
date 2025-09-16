<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Support\Collection;
use Tests\TestCase;

class StudentProductsPageTest extends TestCase
{
    /**
     * Test if the view has required data.
     */
    public function test_if_the_view_has_required_data(): void
    {
        $response = $this->get(route('student.products'));

        $response->assertStatus(200);
        $response->assertViewHasAll([
            'products' => function (Collection $products) {
                foreach ($products as $product) {
                    $this->assertInstanceOf(Product::class, $product);
                }
                return true;
            },
        ]);
    }

    /**
     * Test search products with random words.
     */
    public function test_search_products_with_random_words(): void
    {
        $searchQueries = fake()->words(10);

        foreach ($searchQueries as $searchQuery) {
            $response = $this->get(route('student.products', ['search' => $searchQuery]));

            $response->assertStatus(200);
            $response->assertViewHasAll([
                'products' => function (Collection $products) {
                    foreach ($products as $product) {
                        $this->assertInstanceOf(Product::class, $product);
                    }
                    return true;
                },
            ]);
        }
    }

    /**
     * Test search products with existing product name.
     */
    public function test_search_products_with_existing_product_name(): void
    {
        $searchQueries = Product::query()->limit(10)->pluck('name')->toArray();

        foreach ($searchQueries as $searchQuery) {
            $response = $this->get(route('student.products', ['search' => $searchQuery]));

            $response->assertStatus(200);
            $response->assertViewHasAll([
                'products' => function (Collection $products) {
                    if ($products->count() <= 0) {
                        return false;
                    }
                    foreach ($products as $product) {
                        $this->assertInstanceOf(Product::class, $product);
                    }
                    return true;
                },
            ]);
        }
    }
}
