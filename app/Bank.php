<?php

namespace App;

use App\Models\Transaction;

abstract class Bank
{
    public function __construct()
    {

    }

    abstract public function receive(string $transactionData);

    abstract public function send();

    abstract protected function parse(string $transaction);

    protected function storeTransaction(array $data)
    {
        Transaction::create([
            'date' => $data['date'] ?? null,
            'amount' => $data['amount'] ?? null,
            'reference' => $data['reference'] ?? null,
            'meta_data' => $data['meta_Data'] ?? null,
            'client_id' => 1,
            'bank_id' => 1,
        ]);
    }

    protected function checkTransaction($transaction)
    {
        return Transaction::where('reference', $transaction)->exists();
    }


}
