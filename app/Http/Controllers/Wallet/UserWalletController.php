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

            $sender_wallet = $sender->userBalance()->lockForUpdate()->first();

            $receiver = User::where('phone_number', $validated['receiver_phone_number'])
                ->with(['userBalance' => function ($query) {
                    $query->lockForUpdate();
                }])
                ->first();

                dd($receiver->userBalance->amount , $sender_wallet->amount);
            if (!$receiver) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'Receiver not found'
                ], 404);
            }
            dd($sender_wallet);
            // ?todo check if the sender has enough balance
            if ($sender_wallet < $validated['amount']) {
                return response()->json([
                    'status' => 'false',
                    'message' => 'Insufficient balance'
                ], 400);
            }

            // ?todo handle the balance update
            $sender_wallet -= $validated['amount'];
            $sender_wallet->save();

            $receiver += $validated['amount'];
            $receiver->save();

            return response()->json([
                'status' => 'true',
                'message' => 'Money sent successfully'
            ]);
        });
}
}
