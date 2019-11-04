<?php

namespace FioApi;

class Account
{
    /** @var string */
    protected $accountNumber;

    /** @var string */
    protected $bankCode;

    /** @var string */
    protected $currency;

    /** @var string */
    protected $iban;

    /** @var string */
    protected $bic;

    public function __construct(
        string $accountNumber,
        string $bankCode,
        string $currency = null,
        string $iban = null,
        string $bic = null
    ) {
        $this->accountNumber = $accountNumber;
        $this->bankCode = $bankCode;
        $this->currency = $currency;
        $this->iban = $iban;
        $this->bic = $bic;
    }

    /**
     * @return string
     */
    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    /**
     * @return string
     */
    public function getBankCode(): string
    {
        return $this->bankCode;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getIban(): string
    {
        return $this->iban;
    }

    /**
     * @return string
     */
    public function getBic(): string
    {
        return $this->bic;
    }
}
