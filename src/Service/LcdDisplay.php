<?php

namespace App\Service;

use App\Service\LcdDisplayInterface;

final class LcdDisplay implements LcdDisplayInterface
{
    private const DIGITS = [
        ' _     _  _     _  _  _  _  _ ',
        '| |  | _| _||_||_ |_   ||_||_|',
        '|_|  ||_  _|  | _||_|  ||_| _|',
    ];
    public function show(string $message): string
    {
        $message = preg_replace("/[^0-9]/", "", $message );

        return $this->convert($message);
    }

    private function convert(string $message): string
    {
        $result = ['', '', ''];
        foreach (mb_str_split($message) as $char) {
            $digit = (int) $char;

            for ($i = 0; $i < 3; $i++) {
                $result[$i] .= $this->getDigitRow(digit: $digit, row: $i);
            }
        }

        return implode("\n\r", $result);
    }

    private function getDigitRow(int $digit, int $row): string
    {
        return mb_substr(self::DIGITS[$row], $digit * 3, 3);
    }
}
