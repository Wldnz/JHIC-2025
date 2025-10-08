<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "display_name" => "Credit Card",
                "code_name"    => "credit_card",
                "is_enable"    => true,
                "icon_url"     => "https://placehold.co/80x80",
            ],
            [
                "display_name" => "BCA Virtual Account",
                "code_name"    => "bca_va",
                "is_enable"    => true,
                "icon_url"     => "https://placehold.co/80x80",
            ],
            [
                "display_name" => "Permata Virtual Account",
                "code_name"    => "permata_va",
                "is_enable"    => true,
                "icon_url"     => "https://placehold.co/80x80",
            ],
            [
                "display_name" => "BNI Virtual Account",
                "code_name"    => "bni_va",
                "is_enable"    => false,
                "icon_url"     => "https://placehold.co/80x80",
            ],
            [
                "display_name" => "GoPay",
                "code_name"    => "gopay",
                "is_enable"    => true,
                "icon_url"     => "https://placehold.co/80x80",
            ],
            [
                "display_name" => "ShopeePay",
                "code_name"    => "shopeepay",
                "is_enable"    => false,
                "icon_url"     => "https://placehold.co/80x80",
            ],
            [
                "display_name" => "Indomaret",
                "code_name"    => "indomaret",
                "is_enable"    => true,
                "icon_url"     => "https://placehold.co/80x80",
            ],
            [
                "display_name" => "Alfamart",
                "code_name"    => "alfamart",
                "is_enable"    => true,
                "icon_url"     => "https://placehold.co/80x80",
            ],
        ];

        PaymentType::query()->insert($data);
    }
}
