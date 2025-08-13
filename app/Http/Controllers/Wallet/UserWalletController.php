<?php

namespace App\Http\Controllers\Wallet;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WalletRequest;
use Illuminate\Support\Facades\DB;

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
        
        // قفل رصيد المرسل والمستقبل
        $sender_balance = $sender->getBalanceWithLock();
        $receiver_balance = $receiver->getBalanceWithLock();

        // تحقق من الرصيد
        if ($sender_balance < $validated['amount']) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient balance'
            ], 400);
        }

        // إضافة حركة خصم للمرسل (Debit)
        $sender->balancesApi()->create([
            'balance_type' => 0, // 0 يعني خصم
            'amount' => $validated['amount']
        ]);

        // إضافة حركة إضافة للمستقبل (Credit)
        $receiver->balancesApi()->create([
            'balance_type' => 1, // 1 يعني إضافة
            'amount' => $validated['amount']
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Money sent successfully'
        ]);
    });
}



}