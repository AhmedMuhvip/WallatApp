<?php

namespace App\DTOs;

class SentTransactionDTO
{
    private ?string $reference = null;
    private ?string $date = null;
    private ?float $amount = null;
    private ?string $currency = null;
    private ?string $senderAccountNumber = null;
    private ?string $bankCode = null;
    private ?string $receiverAccountNumber = null;
    private ?string $beneficiaryName = null;
    private array $notes = [];
    private ?string $paymentType = null;
    private ?string $chargeDetails = null;

    public static function create(): self
    {
        return new self();
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;
        return $this;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function setSenderAccountNumber(string $accountNumber): self
    {
        $this->senderAccountNumber = $accountNumber;
        return $this;
    }

    public function setBankCode(string $bankCode): self
    {
        $this->bankCode = $bankCode;
        return $this;
    }

    public function setReceiverAccountNumber(string $accountNumber): self
    {
        $this->receiverAccountNumber = $accountNumber;
        return $this;
    }

    public function setBeneficiaryName(string $name): self
    {
        $this->beneficiaryName = $name;
        return $this;
    }

    public function setNotes(array $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function addNote(string $note): self
    {
        $this->notes[] = $note;
        return $this;
    }

    public function setPaymentType(string $paymentType): self
    {
        $this->paymentType = $paymentType;
        return $this;
    }

    public function setChargeDetails(string $chargeDetails): self
    {
        $this->chargeDetails = $chargeDetails;
        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function getSenderAccountNumber(): ?string
    {
        return $this->senderAccountNumber;
    }

    public function getBankCode(): ?string
    {
        return $this->bankCode;
    }

    public function getReceiverAccountNumber(): ?string
    {
        return $this->receiverAccountNumber;
    }

    public function getBeneficiaryName(): ?string
    {
        return $this->beneficiaryName;
    }

    public function getNotes(): array
    {
        return $this->notes;
    }

    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    public function getChargeDetails(): ?string
    {
        return $this->chargeDetails;
    }

    public function toXml(): string
    {
        $notesXml = '';
        foreach ($this->notes as $note) {
            $notesXml .= "<Note>{$note}</Note>";
        }

        return '<?xml version="1.0" encoding="utf-8"?> ' .
            '<PaymentRequestMessage> ' .
            '<TransferInfo> ' .
            "<Reference>{$this->reference}</Reference>" .
            "<Date>{$this->date}</Date> " .
            "<Amount>{$this->amount}</Amount> " .
            "<Currency>{$this->currency}</Currency> " .
            '</TransferInfo> ' .
            '<SenderInfo> ' .
            "<AccountNumber>{$this->senderAccountNumber}</AccountNumber> " .
            '</SenderInfo> ' .
            '<ReceiverInfo> ' .
            "<BankCode>{$this->bankCode}</BankCode> " .
            "<AccountNumber>{$this->receiverAccountNumber}</AccountNumber> " .
            "<BeneficiaryName>{$this->beneficiaryName}</BeneficiaryName> " .
            '</ReceiverInfo> ' .
            '<Notes> ' .
            $notesXml .
            '</Notes> ' .
            "<PaymentType>{$this->paymentType}</PaymentType> " .
            "<ChargeDetails>{$this->chargeDetails}</ChargeDetails> " .
            '</PaymentRequestMessage>';
    }
}

