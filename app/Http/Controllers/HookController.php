<?php

namespace App\Http\Controllers;

use App\Builders\SentTransactionBuilder;
use App\Http\Requests\HookRequest;
use Illuminate\Http\Request;

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

    public function sent(Request $request)
    {
        $bankName = $request->input('bank');

        if (!$bankName) {
            return response()->json(['message' => 'Bank is required'], 400);
        }

        $sentTransaction = SentTransactionBuilder::create()
            ->fromRequest($request);

        $bankClass = 'App\\' . $bankName . 'Bank';

        $bank = new $bankClass();

        $xml = $bank->send($sentTransaction);

        return response($xml, 200);
    }
}
