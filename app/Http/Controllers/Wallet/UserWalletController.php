<?php

namespace App\Http\Controllers\Wallet;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\WalletRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer\CmnUserBalance;

class UserWalletController extends Controller
{


public function sendMoney(WalletRequest $request)
{
    $validated = $request->validated();
    $sender = Auth::guard('api')->user();
    $receiver = User::where('phone_number', $validated['receiver_phone_number'])->first();

    if (!$receiver) {
        return response()->json([
            'status' => false,
            'message' => 'Receiver not found'
        ], 404);
    }

    return DB::transaction(function () use ($validated, $sender, $receiver) {
        
        // ! Lock the sender's and receiver's balances
        $sender_balance = $sender->getBalanceWithLock();
        $receiver_balance = $receiver->getBalanceWithLock();

        // ?todo check if the sender has enough balance
        if ($sender_balance < $validated['amount']) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient balance'
            ], 400);
        }

        // ?todo handle the balance update
        $sender->balancesApi()->create([
            'balance_type' => 0, //? 0 which means deduction
            'balanceable_type' => User::class,
            'balanceable_id'=> $receiver->id,
            'user_id' => $sender->id,
            'amount' => $validated['amount']
        ]);

        // ?todo save the transaction details if needed
        $receiver->balancesApi()->create([
            'balance_type' => 1, //? 1 which means addition
            'balanceable_type' => User::class,
            'balanceable_id'=> $sender->id,
            'user_id' => $receiver->id,
            'amount' => $validated['amount']
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Money sent successfully'
        ]);
    });
}


public function transaction()
{
    try{

        $transactions = CmnUserBalance::where('balanceable_type', User::class)
            ->where('balanceable_id', auth()->id())
            ->lockForUpdate()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Transactions retrieved successfully',
            'data' => $transactions
        ]);

    }catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'An error occurred while processing the transaction',
            'error' => $e->getMessage()
        ], 500);
    }
}


}