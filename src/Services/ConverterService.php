<?php

namespace App\Services;

class ConverterService
{
    public function convert(array $data): float
    {
        $explodedData = explode('*', $data['currency']);

        $rate = $explodedData[0];
        $_SESSION['currency_name'] = $explodedData[1];
        $_SESSION['calculate_type'] = $data['type'];

        if ($data['type'] == 'from_rub' && $data['number']) {
            $total = (float) $data['number'] / (float)($rate);
            $_SESSION['number'] = $data['number'];
        } else {
            $total = (float) $data['number'] * (float)($rate);
        }

        return ceil($total * 100) / 100;
    }
}