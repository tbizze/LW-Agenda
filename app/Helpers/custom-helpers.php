<?php

use App\Helpers\Classes\Format;
use App\Helpers\Classes\Mask;
use App\Helpers\Classes\Numeral;
use App\Helpers\Classes\Sanitize;
use App\Helpers\Classes\Validate;

if (!function_exists('currency_to_db')) {
    /**
     * Formatar moeda para BD.
     *
     * @param string|float $number Número a formatar
     * @param int $decimals [optional] Número de casas decimais (default: 2)
     *
     * @return string Número formatado
     */
    function currency_to_db(
        float|string $number,
        int $decimals = 2,
    ): string {
        if ($number) {
            return Format::currencyToDb($number, $decimals);
        }
    }
}

if (!function_exists('currency_get_db')) {
    /**
     * Formatar moeda do BD para moeda brasileira.
     *
     * @param string|float $number Número a formatar
     * @param int $decimals [optional] Número de casas decimais (default: 2)
     * @param int $thousandSeparator [optional] Separador de milhar (default: '')
     *
     * @return string Número formatado
     */
    function currency_get_db(
        float|string $number,
        int $decimals = 2,
        string $thousandSeparator = '.'
    ): string {
        // Se existe $number e for diferente de 0, então mascara.
        if ($number && $number <> 0) {
            return Format::currencyGetDb($number, $decimals, $thousandSeparator);
        }
        // Caso $number é null ou = 0, retorna vazio.
        return '';

    }
}

if (!function_exists('currency_extenso')) {
    /**
     * Formatar moeda do BD para moeda brasileira.
     *
     * @param string|float $number Número a formatar
     * @param int $decimals [optional] Número de casas decimais (default: 2)
     * @param int $thousandSeparator [optional] Separador de milhar (default: '')
     *
     * @return string Número formatado
     */
    function currency_extenso($number): string 
    {
        // Se existe $number e for diferente de 0, então mascara.
        if ($number && $number <> 0) {
            return Numeral::currencyToExtenso($number);
        }
        // Caso $number é null ou = 0, retorna vazio.
        return '';
    }
}

if (! function_exists('date_to_db')) {
    /**
     * Formatar data para BD.
     *
     * @param string $date Data a formatar
     *
     * @return string Data formatada
     */
    function date_to_db(string $date): string
    {
        if ($date) {
            return Format::dateToDb($date);
        }
    }
}

if (! function_exists('mask_phone')) {
    /**
     * Formatar data para BD.
     *
     * @param string $date Data a formatar
     *
     * @return string Telefone formatado
     */
    function mask_phone(string $phone): string
    {
        if ($phone) {
            return Mask::phone($phone);
        }
        // Caso $phone é null, retorna vazio.
        return '';
    }
}

if (! function_exists('mask_cpf_cnpj')) {
    /**
     * Formatar CPF/CNPJ para FrontEnd.
     *
     * @param string $cpf_cnpj Valor a formatar
     *
     * @return string Valor formatado
     */
    function mask_cpf_cnpj($cpf_cnpj): string
    {
        if (strlen($cpf_cnpj) == 14) {
            return Mask::cnpj($cpf_cnpj);
        }elseif (strlen($cpf_cnpj) == 11) {
            return Mask::cpf($cpf_cnpj);
        }
        // Caso $cpf_cnpj é null, retorna vazio.
        return '';
    }
}

if (! function_exists('capitalize_words')) {
    /**
     * Formatar data para BD.
     *
     * @param string $date String a formatar
     *
     * @return string String formatado
     */
    function capitalize_words(string $string): string
    {
        if ($string) {
            return Sanitize::capitalizeEachWords($string);
        }
    }
}


if (! function_exists('get_meses')) {
    /**
     * Formatar data para BD.
     *
     * @param string $date String a formatar
     *
     * @return string String formatado
     */
    function get_meses(): array
    {
        $meses = [
            [
                'value' => '1',
                'label' => 'Janeiro',
            ],
            [
                'value' => '2',
                'label' => 'Fevereiro',
            ],
            [
                'value' => '3',
                'label' => 'Março',
            ],
            [
                'value' => '4',
                'label' => 'Abril',
            ],
            [
                'value' => '5',
                'label' => 'Maio',
            ],
            [
                'value' => '6',
                'label' => 'Junho',
            ],
            [
                'value' => '7',
                'label' => 'Junho',
            ],
            [
                'value' => '8',
                'label' => 'Agosto',
            ],
            [
                'value' => '9',
                'label' => 'Setembro',
            ],
            [
                'value' => '10',
                'label' => 'Outubro',
            ],
            [
                'value' => '11',
                'label' => 'Novembro',
            ],
            [
                'value' => '12',
                'label' => 'Dezembro',
            ]
        ];
        return $meses;
    }
}