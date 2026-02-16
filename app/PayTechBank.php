<?php

namespace App;

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
    public function parse(string $transaction)
    {
        $date = Carbon::parse(substr($transaction, 0, 8))->format('Y-m-d H:i:s');
        $string = str_replace(['#', '/'], '&', $transaction);
        $transaction = explode('&', $string);
        $amount = str_replace(',', '.', substr($transaction[0], 8, 6));
        [, $referenceCode, $note, $noteData, $internal, $internalCOde] = $transaction;
        $data = [$note => $noteData, $internal => $internalCOde];

        return ['date' => $date, 'amount' => $amount, 'reference' => $referenceCode, 'meta_Data' => $data];
    }
}
