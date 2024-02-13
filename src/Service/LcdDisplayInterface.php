<?php

namespace App\Service;

interface LcdDisplayInterface
{
    public function show(string $message): string;
}