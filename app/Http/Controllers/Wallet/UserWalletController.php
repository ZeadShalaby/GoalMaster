<?php

namespace App\Http\Controllers\Wallet;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WalletRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class UserWalletController extends Controller
{
   public function sendMoney(WalletRequest $request)
    {
        $validated = $request->validated();
        $sender = Auth::guard('api')->user();

        return DB::transaction(function () use ($validated, $sender) {

            $sender_wallet = $sender->wallet()->lockForUpdate()->first();

            $receiver = User::where('phone_number', $validated['receiver_phone_number'])
                ->with(['wallet' => function ($query) {
                    $query->lockForUpdate();
                }])
                ->first();

            if (!$receiver) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'Receiver not found'
                ], 404);
            }

            // ?todo check if the sender has enough balance
            if ($sender_wallet->balance < $validated['amount']) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'Insufficient balance'
                ], 400);
            }

            // ?todo handle the balance update
            $sender_wallet->balance -= $validated['amount'];
            $sender_wallet->save();

            $receiver->wallet->balance += $validated['amount'];
            $receiver->wallet->save();

            return response()->json([
                'status' => 'true',
                'message' => 'Money sent successfully'
            ]);
        });
}
}
