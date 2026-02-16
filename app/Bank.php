<?php

namespace App;

use App\Models\Transaction;
use SentTransaction;

abstract class Bank
{
    public function __construct()
    {

    }

    public function receive($transactions): void
    {
        $transactionsArray = explode("\n", $transactions);
        foreach ($transactionsArray as $transaction => $data) {
            $dataArr = $this->parse($data);
            if ($this->checkTransaction($dataArr['reference'])) return;
            $this->storeTransaction($dataArr);
        }
    }

     public function send(SentTransaction $transaction){

     }

    abstract protected function parse(string $transaction);

    private function storeTransaction(array $data): void
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

    private function checkTransaction($transaction)
    {
        return Transaction::where('reference', $transaction)->exists();
    }

}
