<?php

namespace FioApi;

class Transaction
{
    /** @var string */
    protected $id;

    /** @var \DateTime */
    protected $date;

    /** @var float */
    protected $amount;

    /** @var string */
    protected $currency;

    /** @var string */
    protected $accountNumber;

    /** @var string */
    protected $bankCode;

    /** @var string */
    protected $bankName;

    /** @var string */
    protected $senderName;

    /** @var string|null */
    protected $constantSymbol;

    /** @var string|null */
    protected $variableSymbol;

    /** @var string|null */
    protected $specificSymbol;

    /** @var string|null */
    protected $userIdentity;

    /** @var string|null */
    protected $userMessage;

    /** @var string */
    protected $transactionType;

    /** @var string|null */
    protected $performedBy;

    /** @var string|null */
    protected $comment;

    /** @var string */
    protected $paymentOrderId;

    /** @var string|null */
    protected $specification;

    /** @var string  */
    protected $benefName;

    /** @var string */
    protected $benefStreet;

    /** @var string */
    protected $benefCity;

    /** @var string */
    protected $benefCountry;

    // @codingStandardsIgnoreStart
    protected function __construct(
        $id,
        \DateTime $date,
        $amount,
        $currency,
        $accountNumber,
        $bankCode,
        $bankName,
        $constantSymbol,
        $variableSymbol,
        $specificSymbol,
        $userIdentity,
        $userMessage,
        $transactionType,
        $performedBy,
        $comment,
        $paymentOrderId,
        $specification,
        $senderName
    )
    {
        $this->id = $id;
        $this->date = $date;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->accountNumber = $accountNumber;
        $this->bankCode = $bankCode;
        $this->bankName = $bankName;
        $this->constantSymbol = $constantSymbol;
        $this->variableSymbol = $variableSymbol;
        $this->specificSymbol = $specificSymbol;
        $this->userIdentity = $userIdentity;
        $this->userMessage = $userMessage;
        $this->transactionType = $transactionType;
        $this->performedBy = $performedBy;
        $this->comment = $comment;
        $this->paymentOrderId = $paymentOrderId;
        $this->specification = $specification;
        $this->senderName = $senderName;
    }

    /**
     * @param \stdClass $data Transaction data from JSON API response
     *
     * @return Transaction
     * @throws \Exception
     */
    public static function createFromJson(\stdClass $data)
    {
        $mapColumnToProps = [
            'column22' => 'id',
            'column0' => 'date',
            'column1' => 'amount',
            'column14' => 'currency',
            'column2' => 'accountNumber',
            'column3' => 'bankCode',
            'column12' => 'bankName',
            'column4' => 'constantSymbol',
            'column5' => 'variableSymbol',
            'column6' => 'specificSymbol',
            'column7' => 'userIdentity',
            'column16' => 'userMessage',
            'column8' => 'transactionType',
            'column9' => 'performedBy',
            'column10' => 'senderName',
            'column25' => 'comment',
            'column17' => 'paymentOrderId',
            'column18' => 'specification',
        ];

        $newData = new \stdClass();
        foreach ($data as $key => $value) {
            if (isset($mapColumnToProps[$key])) {
                $newKey = $mapColumnToProps[$key];
                if ($value !== null) {
                    if ($newKey === 'date') {
                        $newData->{$newKey} = new \DateTime($value->value);
                    } else {
                        $newData->{$newKey} = $value->value;
                    }
                } else {
                    $newData->{$newKey} = null;
                }
            }
        }

        return self::create($newData);
    }

    /**
     * @param \stdClass $data Transaction data from JSON API response
     *
     * @return Transaction
     */
    public static function create(\stdClass $data): Transaction
    {
        return new self(
            $data->id,
            $data->date,
            $data->amount,
            $data->currency,
            $data->accountNumber,
            $data->bankCode,
            $data->bankName,
            $data->constantSymbol,
            $data->variableSymbol ?: '0',
            $data->specificSymbol,
            $data->userIdentity,
            $data->userMessage,
            $data->transactionType,
            $data->performedBy,
            $data->comment,
            $data->paymentOrderId,
            $data->specification,
            $data->senderName
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    public function getSenderName(): string
    {
        return $this->senderName;
    }

    public function getBankCode(): string
    {
        return $this->bankCode;
    }

    public function getConstantSymbol(): ?string
    {
        return $this->constantSymbol;
    }

    public function getVariableSymbol(): ?string
    {
        return $this->variableSymbol;
    }

    public function getSpecificSymbol(): ?string
    {
        return $this->specificSymbol;
    }

    public function getUserIdentity(): ?string
    {
        return $this->userIdentity;
    }

    public function getUserMessage(): ?string
    {
        return $this->userMessage;
    }

    public function getTransactionType(): string
    {
        return $this->transactionType;
    }

    public function getPerformedBy(): ?string
    {
        return $this->performedBy;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getPaymentOrderId(): ?string
    {
        return $this->paymentOrderId;
    }

    public function getSpecification(): ?string
    {
        return $this->specification;
    }
}
