<?php

class Currency
{
    const CB_URL = "https://cbu.uz/uz/arkhiv-kursov-valyut/json/";

    public function exchange(float|int $amount, string $fromCurrency, string $toCurrency): string
    {
        $currencies = $this->customCurrencies();
        $fromRate = $currencies[$fromCurrency];
        $toRate = $currencies[$toCurrency];

        $convertedAmount = ($amount / $fromRate) * $toRate;
        $roundedAmount = number_format($convertedAmount, 2);
        return $roundedAmount;
    }

    public function getCurrencyInfo(): array
    {
        $currencyInfo = file_get_contents(self::CB_URL);
        return json_decode($currencyInfo, true);
    }

    public function customCurrencies(): array
    {
        $currencies = $this->getCurrencyInfo();
        $orderedCurrencies = [];

        foreach ($currencies as $currency) {
            $orderedCurrencies[$currency['Ccy']] = $currency['Rate'];
        }

        return $orderedCurrencies;
    }
}
?>
