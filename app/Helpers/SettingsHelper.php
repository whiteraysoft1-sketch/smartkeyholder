<?php

if (!function_exists('setting')) {
    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        return \App\Models\Setting::get($key, $default);
    }
}

if (!function_exists('settings_group')) {
    /**
     * Get all settings by group
     *
     * @param string $group
     * @return \Illuminate\Support\Collection
     */
    function settings_group($group)
    {
        return \App\Models\Setting::getByGroup($group);
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format currency based on settings
     *
     * @param float $amount
     * @param string $currency
     * @return string
     */
    function format_currency($amount, $currency = null)
    {
        $symbol = setting('currency_symbol', '$');
        $position = setting('currency_position', 'before');
        $defaultCurrency = setting('default_currency', 'USD');
        
        // Use custom currency if set
        if ($defaultCurrency === 'CUSTOM') {
            $symbol = setting('custom_currency_symbol', $symbol);
        }
        
        $formattedAmount = number_format($amount, 2);
        
        if ($position === 'after') {
            return $formattedAmount . $symbol;
        } else {
            return $symbol . $formattedAmount;
        }
    }
}

if (!function_exists('get_currency_code')) {
    /**
     * Get current currency code
     *
     * @return string
     */
    function get_currency_code()
    {
        $defaultCurrency = setting('default_currency', 'USD');
        
        if ($defaultCurrency === 'CUSTOM') {
            return setting('custom_currency_code', 'USD');
        }
        
        return $defaultCurrency;
    }
}