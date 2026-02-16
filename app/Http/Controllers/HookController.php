<?php

namespace App\Http\Controllers;

use App\Http\Requests\HookRequest;

class HookController extends Controller
{
    public function receive(HookRequest $request)
    {
        $bank = $request->input('bank');
        $transactionData = $request->input('transaction_data');

        if (!$bank || !$transactionData) {
            return response()->json(['message' => 'Bank and transaction data are required'], 400);
        }


        $bankClass = 'App\\' . $bank . 'Bank';
        $bank = new $bankClass();
        $bank->receive($transactionData);
        return response()->json(['message' => 'success']);

    }
}
