<?php

namespace FioApi;

class TransactionList
{
    /** @var float */
    protected $openingBalance;

    /** @var float */
    protected $closingBalance;

    /** @var \DateTime */
    protected $dateStart;

    /** @var \DateTime */
    protected $dateEnd;

    /** @var float */
    protected $idFrom;

    /** @var float */
    protected $idTo;

    /** @var int */
    protected $idLastDownload;

    /** @var Account */
    protected $account;

    /** @var Transaction[] */
    protected $transactions = [];

    /**
     * TransactionList constructor.
     * @param float $openingBalance
     * @param float $closingBalance
     * @param \DateTime $dateStart
     * @param \DateTime $dateEnd
     * @param float|null $idFrom
     * @param float|null $idTo
     * @param int|null $idLastDownload
     * @param Account $account
     */
    protected function __construct(
        float $openingBalance,
        float $closingBalance,
        \DateTime $dateStart,
        \DateTime $dateEnd,
        ?float $idFrom,
        ?float $idTo,
        ?int $idLastDownload,
        Account $account
    ) {
        $this->openingBalance = $openingBalance;
        $this->closingBalance = $closingBalance;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->idFrom = $idFrom;
        $this->idTo = $idTo;
        $this->idLastDownload = $idLastDownload;
        $this->account = $account;
    }

    /**
     * @param Transaction $transaction
     */
    protected function addTransaction(Transaction $transaction)
    {
        $this->transactions[] = $transaction;
    }

    /**
     * @param \stdClass $data Data from JSON API response
     *
     * @return TransactionList
     * @throws \Exception
     */
    public static function create(\stdClass $data): TransactionList
    {
        $account = new Account(
            $data->info->accountId,
            $data->info->bankId,
            $data->info->currency,
            $data->info->iban,
            $data->info->bic
        );

        $transactionList = new self(
            $data->info->openingBalance,
            $data->info->closingBalance,
            new \DateTime($data->info->dateStart),
            new \DateTime($data->info->dateEnd),
            $data->info->idFrom,
            $data->info->idTo,
            $data->info->idLastDownload,
            $account
        );

        foreach ($data->transactionList->transaction as $transaction) {
            $transactionList->addTransaction(Transaction::createFromJson($transaction));
        }

        return $transactionList;
    }

    /**
     * @return float
     */
    public function getOpeningBalance(): float
    {
        return $this->openingBalance;
    }

    public function getClosingBalance(): float
    {
        return $this->closingBalance;
    }

    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    public function getDateEnd(): \DateTime
    {
        return $this->dateEnd;
    }

    public function getIdFrom(): ?float
    {
        return $this->idFrom;
    }

    public function getIdTo(): ?float
    {
        return $this->idTo;
    }

    public function getIdLastDownload(): ?int
    {
        return $this->idLastDownload;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }
}
