<?php

namespace App\Services;

class PasswordGenerator
{
    private $length;
    private $useSmall;
    private $useCapital;
    private $useNumbers;
    private $useSymbols;
    private $symbols = ['!', '#', '$', '%', '&', '(', ')', '*', '+', '@', '^'];

    public function __construct(int $length = 8, bool $useSmall = true, bool $useCapital = true, bool $useNumbers = true, bool $useSymbols = true)
    {
        $this->length = $length;
        $this->useSmall = $useSmall;
        $this->useCapital = $useCapital;
        $this->useNumbers = $useNumbers;
        $this->useSymbols = $useSymbols;
    }

    public function generate(): string
    {
        $characters = '';
        $password = '';

        if ($this->useSmall) {
            $characters .= 'abcdefghijklmnopqrstuvwxyz';
        }

        if ($this->useCapital) {
            $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        if ($this->useNumbers) {
            $characters .= '0123456789';
        }

        if ($this->useSymbols) {
            $characters .= implode('', $this->symbols);
        }

        $charactersLength = strlen($characters);

        for ($i = 0; $i < $this->length; $i++) {
            $password .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $password;
    }
}
