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

    /**
     * Account owner.
     *
     * @var string
     */
    protected $benefName;

    /**
     * Street of account owner.
     *
     * @var string
     */
    protected $benefStreet;

    /**
     * City of account owner.
     *
     * @var string
     */
    protected $benefCity;

    /**
     * Country of account owner.
     *
     * @var string
     */
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
        $benefName,
        $benefStreet,
        $benefCity,
        $benefCountry
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
        $this->benefName = $benefName;
        $this->benefStreet = $benefStreet;
        $this->benefCity = $benefCity;
        $this->benefCountry = $benefCountry;
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
            'column25' => 'comment',
            'column17' => 'paymentOrderId',
            'column18' => 'specification',
        ];

        $newData = new \stdClass();
        foreach ($data as $key => $value) {
            if (isset($mapColumnToProps[$key]) && $value !== null) {
                $newKey = $mapColumnToProps[$key];
                if ($newKey === 'date') {
                    $newData->{$newKey} = new \DateTime($value->value);
                } else {
                    $newData->{$newKey} = $value->value;
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
            !empty($data->id) ? $data->id : null,
            $data->date,
            $data->amount,
            $data->currency,
            !empty($data->accountNumber) ? $data->accountNumber : null,
            !empty($data->bankCode) ? $data->bankCode : null,
            !empty($data->bankName) ? $data->bankName : null,
            !empty($data->constantSymbol) ? $data->constantSymbol : null,
            !empty($data->variableSymbol) ? $data->variableSymbol : '0',
            !empty($data->specificSymbol) ? $data->specificSymbol : null,
            !empty($data->userIdentity) ? $data->userIdentity : null,
            !empty($data->userMessage) ? $data->userMessage : null,
            !empty($data->transactionType) ? $data->transactionType : null,
            !empty($data->performedBy) ? $data->performedBy : null,
            !empty($data->comment) ? $data->comment : null,
            !empty($data->paymentOrderId) ? $data->paymentOrderId : null,
            !empty($data->specification) ? $data->specification : null,
            !empty($data->benefName) ? $data->benefName : null,
            !empty($data->benefStreet) ? $data->benefStreet : null,
            !empty($data->benefCity) ? $data->benefCity : null,
            !empty($data->benefCountry) ? $data->benefCountry : null
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

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @return string
     */
    public function getBankCode()
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

    /**
     * @return string
     */
    public function getBenefName()
    {
        return $this->benefName;
    }

    /**
     * @return string
     */
    public function getBenefStreet()
    {
        return $this->benefStreet;
    }

    /**
     * @return string
     */
    public function getBenefCity()
    {
        return $this->benefCity;
    }

    /**
     * @return string
     */
    public function getBenefCountry()
    {
        return $this->benefCountry;
    }
}
