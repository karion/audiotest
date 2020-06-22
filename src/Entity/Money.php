<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Money
{
    const CURRENCY_PLN = 'PLN';
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_USD = 'USD';

    public static $allowedCurrency = [
        self::CURRENCY_PLN,
        self::CURRENCY_EUR,
        self::CURRENCY_USD,
    ];

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $cents = 0;


    /**
     * @var string
     * @ORM\Column(type="string", length=3)
     */
    private $currency = 'PLN';

    public function getCents(): int
    {
        return (int)$this->cents;
    }

    public function setCents(int $cents): self
    {
        $this->cents = (string)$cents;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = strtoupper($currency);

        return $this;
    }
}
