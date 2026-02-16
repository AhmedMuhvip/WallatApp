<?php

namespace App;

use Carbon\Carbon;
use Psy\Exception\ParseErrorException;

class AcmeBank extends Bank
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
        try {

            $data = explode('//', $transaction);
            [, $reference, $date] = $data;
            $formatedDate = Carbon::parse($date)->format('Y-m-d H:i:s');
            $amount = str_replace(',', '.', $data[0]);
            return ['date' => $formatedDate, 'amount' => $amount, 'reference' => $reference];
        } catch (\Exception $e) {
            throw new ParseErrorException($e->getMessage());
        }

    }
}
