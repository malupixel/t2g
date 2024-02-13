<?php

namespace App\Service;

final class CodeBreaker implements CodeBreakerInterface
{
    public function __construct(
        private readonly string $codeTemplateDecoded,
        private readonly string $codeTemplateEncoded
    ) {}

    public function decode(string $message): string
    {
        return $this->changeMessage(
            chars: mb_str_split($message),
            fromCode: $this->codeTemplateEncoded,
            toCode: $this->codeTemplateDecoded
        );
    }

    public function encode(string $message): string
    {
        return $this->changeMessage(
            chars: mb_str_split($message),
            fromCode: $this->codeTemplateDecoded,
            toCode: $this->codeTemplateEncoded
        );
    }

    private function changeMessage(array $chars, string $fromCode, string $toCode): string
    {
        $modifiedMessage = '';
        foreach ($chars as $char) {
            $position = mb_strpos($fromCode, $char);
            if ($position !== false) {
                $modifiedMessage.= mb_substr($toCode, $position, 1);
                continue;
            }
            $modifiedMessage.= $char;
        }

        return $modifiedMessage;
    }
}
