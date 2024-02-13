<?php

namespace App\Service;

interface CodeBreakerInterface
{
    public function decode(string $message): string;
    public function encode(string $message): string;
}
