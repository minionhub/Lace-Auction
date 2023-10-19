<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Winner;

class CronController extends Controller
{
    public function selectWinner()
    {
        $general = GeneralSetting::first();
        $now = now();
        $general->last_cron = $now;
        $general->save();

        $products = Product::where('end_date','<',$now)->where('status',1)->where('bid_complete',0)->get();
        foreach ($products as $product){
            $winnerBid = $product->bids()->orderByDesc('bid_amount')->first();
            if(!$winnerBid){
                continue;
            }

            //Winner
            $winner = new Winner();
            $winner->bid_id = $winnerBid->id;
            $winner->user_id = $winnerBid->user_id;
            $winner->save();
            
            //Send email to winner
            notify($winner->user, 'SELECTED_WINNER', [
                'product_name' => $winnerBid->product->name,
                'product_link' => route('auction.details', [$winnerBid->product->id, slug($winnerBid->product->name)])
            ]);


            //Refund money to not winners
            $notWinnerBids = $product->bids()->where('id','!=',$winnerBid->id)->get();
            foreach ($notWinnerBids as $bid){
                $bid->user->balance += $bid->total_amount;
                $bid->user->save();

                //Transaction
                $transaction = new Transaction();
                $transaction->user_id = $bid->user->id;
                $transaction->amount = getAmount($bid->total_amount);
                $transaction->post_balance = getAmount($bid->user->balance);
                $transaction->trx_type = '+';
                $transaction->details = 'Refund bid amount for ' . $bid->product->name;
                $transaction->trx = getTrx();
                $transaction->save();

                //Send email for refund bid amount
                notify($bid->user, 'BID_CLOSED', [
                    'product_name' => $bid->product->name,
                    'product_link' => route('auction.details', [$bid->product->id, slug($bid->product->name)])
                ]);
            }

            //Product bid complete updated
            $product->bid_complete = 1;
            $product->winner_id = $winner->id;
            $product->save();
        }
    }
}
