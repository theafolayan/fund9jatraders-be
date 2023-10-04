<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PlatformSettings extends Settings
{


    public string $site_name;
    public string $site_description;
    public bool $lock_purchases;
    public bool $lock_withdrawals;
    public bool $lock_referrals;
    public string $challenge_purchase_description;
    public int $affiliate_percentage;
    public int $affiliate_minimum_withdrawal;
    public int $minimum_withdrawal;

    // product prices

    public int $product_one_price;
    public string $product_one_title;
    public string $product_one_description;

    public int $product_two_price;
    public string $product_two_title;
    public string $product_two_description;

    public int $product_three_price;
    public string $product_three_title;
    public string $product_three_description;



    public static function group(): string
    {
        return 'platform';
    }
}
