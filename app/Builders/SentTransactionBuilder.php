<?php

namespace App\Builders;

use App\DTOs\SentTransactionDTO;
use Illuminate\Http\Request;

class SentTransactionBuilder
{
    protected SentTransactionDTO $sentTransactionDTO;

    public function __construct()
    {
        $this->sentTransactionDTO = new SentTransactionDTO();
    }

    public static function create(): self
    {
        return new self();
    }

    public function fromRequest(Request $request): SentTransactionDTO
    {
        return $this->setReference($request->input('reference'))
            ->setDate($request->input('date'))
            ->setAmount((float) $request->input('amount'))
            ->setCurrency($request->input('currency'))
            ->setSenderAccountNumber($request->input('senderAccountNumber'))
            ->setBankCode($request->input('bankCode'))
            ->setReceiverAccountNumber($request->input('receiverAccountNumber'))
            ->setBeneficiaryName($request->input('beneficiaryName'))
            ->setNotes($request->input('notes', []))
            ->setPaymentType($request->input('paymentType'))
            ->setChargeDetails($request->input('chargeDetails'))
            ->build();
    }

    public function setReference(string $reference): self
    {
        $this->sentTransactionDTO->setReference($reference);
        return $this;
    }

    public function setDate(string $date): self
    {
        $this->sentTransactionDTO->setDate($date);
        return $this;
    }

    public function setAmount(float $amount): self
    {
        $this->sentTransactionDTO->setAmount($amount);
        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->sentTransactionDTO->setCurrency($currency);
        return $this;
    }

    public function setSenderAccountNumber(string $accountNumber): self
    {
        $this->sentTransactionDTO->setSenderAccountNumber($accountNumber);
        return $this;
    }

    public function setBankCode(string $bankCode): self
    {
        $this->sentTransactionDTO->setBankCode($bankCode);
        return $this;
    }

    public function setReceiverAccountNumber(string $accountNumber): self
    {
        $this->sentTransactionDTO->setReceiverAccountNumber($accountNumber);
        return $this;
    }

    public function setBeneficiaryName(string $name): self
    {
        $this->sentTransactionDTO->setBeneficiaryName($name);
        return $this;
    }

    public function setNotes(array $notes): self
    {
        $this->sentTransactionDTO->setNotes($notes);
        return $this;
    }

    public function addNote(string $note): self
    {
        $this->sentTransactionDTO->addNote($note);
        return $this;
    }

    public function setPaymentType(string $paymentType): self
    {
        $this->sentTransactionDTO->setPaymentType($paymentType);
        return $this;
    }

    public function setChargeDetails(string $chargeDetails): self
    {
        $this->sentTransactionDTO->setChargeDetails($chargeDetails);
        return $this;
    }

    public function build(): SentTransactionDTO
    {
        return $this->sentTransactionDTO;
    }
}

