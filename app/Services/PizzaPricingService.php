<?php

namespace App\Services;

class PizzaPricingService
{
    private $basePrices = [
        'small' => 15,
        'medium' => 22,
        'large' => 30,
    ];

    private $pepperoniPrices = [
        'small' => 3,
        'medium' => 5,
        'large' => 0,
    ];

    private $extraCheesePrice = 6;

    public function calculatePricing($size, $pepperoni, $extraCheese)
    {
        $basePrice = $this->basePrices[$size];
        $pepperoniPrice = $pepperoni ? $this->pepperoniPrices[$size] : 0;
        $extraCheesePrice = $extraCheese ? $this->extraCheesePrice : 0;

        $totalPrice = $basePrice + $pepperoniPrice + $extraCheesePrice;

        return [
            'base_price' => $basePrice,
            'pepperoni_price' => $pepperoniPrice,
            'extra_cheese_price' => $extraCheesePrice,
            'total_price' => $totalPrice,
        ];
    }
}
