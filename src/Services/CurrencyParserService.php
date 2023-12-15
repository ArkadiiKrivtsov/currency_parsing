<?php

namespace App\Services;

use App\Repository\CurrenciesRepository;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CurrencyParserService
{
    public function getCurrencies(): array
    {
        $numCodes = $this->getNumCodes();
        $currentDate = date('d/m/Y');

        $client = new Client();

        try {
            $response = $client->get(
                'https://www.cbr.ru/scripts/XML_daily.asp',
                ['query' => ['date_req' => $currentDate]]
            );
        } catch (GuzzleException $e) {
            $_SESSION['error_message'] = 'Сервис временно недоступен.';
        }

        $currenciesRates = [];

        if (isset($response)) {
            $xml = simplexml_load_string($response->getBody());
            $jsonData = json_encode($xml);
            $currencies = json_decode($jsonData, true);

            foreach ($currencies['Valute'] as $currency) {
                foreach ($numCodes as $numCode) {
                    if ($currency['NumCode'] == $numCode['code']) {
                        $currenciesRates[] = [
                            'name' => $numCode['name'],
                            'value' => $currency['Value'],
                        ];
                    }
                }
            }
        }

        return $currenciesRates;
    }

    public function update(): bool
    {
        $currencies = $this->getCurrencies();
        $currenciesRepository = new CurrenciesRepository();
        return $currenciesRepository->update($currencies);
    }

    private function getNumCodes(): array
    {
        return [
            ['name' => 'USD', 'code' => '840'],
            ['name' => 'EUR', 'code' => '978'],
            ['name' => 'CNY', 'code' => '156'],
        ];
    }
}
