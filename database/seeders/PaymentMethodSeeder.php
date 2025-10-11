<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::query()->insert([
            [
                "display_name" => "Credit Card",
                "code_name"    => "credit_card",
                "is_enabled"    => true,
                "icon_url"     => "https://placehold.co/80x80",
            ],
            [
                "display_name" => "BCA Virtual Account",
                "code_name"    => "bca_va",
                "is_enabled"    => true,
                "icon_url"     => "https://placehold.co/80x80",
            ],
            [
                "display_name" => "Permata Virtual Account",
                "code_name"    => "permata_va",
                "is_enabled"    => true,
                "icon_url"     => "https://placehold.co/80x80",
            ],
            [
                "display_name" => "BNI Virtual Account",
                "code_name"    => "bni_va",
                "is_enabled"    => false,
                "icon_url"     => "https://placehold.co/80x80",
            ],
            [
                "display_name" => "GoPay",
                "code_name"    => "gopay",
                "is_enabled"    => true,
                "icon_url"     => "https://placehold.co/80x80",
            ],
            [
                "display_name" => "ShopeePay",
                "code_name"    => "shopeepay",
                "is_enabled"    => false,
                "icon_url"     => "https://placehold.co/80x80",
            ],
            [
                "display_name" => "Indomaret",
                "code_name"    => "indomaret",
                "is_enabled"    => true,
                "icon_url"     => "https://placehold.co/80x80",
            ],
            [
                "display_name" => "Alfamart",
                "code_name"    => "alfamart",
                "is_enabled"    => true,
                "icon_url"     => "https://placehold.co/80x80",
            ],
        ]);
    }
}
