<?php

namespace App;

use App\Models\Transaction;
use Illuminate\Support\Carbon;

class PayTechBank extends Bank
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function receive(string $transactionData)
    {

        $dataArr = $this->parse($transactionData);
        if ($this->checkTransaction($dataArr['reference'])) return;
        $this->storeTransaction($dataArr);
        return response()->json(['message' => 'success']);
    }

    public function send()
    {
        // TODO: Implement send() method.
    }

    public function parse(string $transaction)
    {
        $date = Carbon::parse(substr($transaction, 0, 8))->format('Y-m-d H:i:s');
        $string = str_replace(['#', '/'], '&', $transaction);
        $transaction = explode('&', $string);
        $amount = str_replace(',', '.', substr($transaction[0], 8, 6));
        [, $referenceCode, $note, $noteData, $intetnal, $internalCOde] = $transaction;
        $data = [$note => $noteData, $intetnal => $internalCOde];

        return ['date' => $date, 'amount' => $amount, 'reference' => $referenceCode, 'meta_Data' => $data];
    }
}
