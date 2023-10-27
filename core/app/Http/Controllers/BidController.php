<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Bid;
use App\Models\ProxyBid;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Winner;
use Illuminate\Http\Request;

use App\Events\MyEvent;

class BidController extends Controller
{
    public function bid(Request $request, $product_id, $slug)
    {
        $product = Product::running()->where('id',$product_id)->firstOrFail();
        if (count($product->bids) > 0){
            $min_amount = getAmount($product->bids->max('bid_amount'));

            $request->validate([
                'amount' => 'required|numeric|gt:'. $min_amount
            ]);
        } else {
            $min_amount = getAmount($product->min_bid_price);

            $request->validate([
                'amount' => 'required|numeric|gte:'. $min_amount
            ]);
        }

        $_existing_user_bid = $product->userBidExist();
        $total_payable = $request->amount + $product->shipping_cost;

        // Subtract User balance
        $user = auth()->user();
        if ($user->balance < $total_payable){
            $notify[] = ['error', "You don't have enough balance! Please deposit and bid again."];
            return $notify;
        }


        // if Auction Close  $user->balance -= $total_payable;
        // $user->balance -= $total_payable;

        $user->save();
        
        if ($request->proxyBidding == 'on') {   
            $record = ProxyBid::where('product_id', $product_id)->first();
            if ($record) {
                if ($record->max_amount < $request->amount) {
                    $record->user_id = $user->id;
                    $record->max_amount = $request->amount;
                    // bid the new user
                } else {
                    // bid
                }
            } else {
                $record = new ProxyBid();
                $record->user_id = $user->id;
                $record->product_id = $product_id;
                $record->max_amount = $request->amount;

                //bid
            }
            $record->save();
        }
         else {
            // proxyBidding == 'off'
            $record = ProxyBid::where('product_id', $product_id)->first();
            if ($record) {
                // proxyBidding exist
                //bid
            } else {
                // proxy doesn't exist
                // general bid
            }
            
        }

        //Bid
        $bid = new Bid();
        $bid->product_id = $product_id;
        $bid->user_id = $user->id;
        $bid->bid_amount = $request->amount;
        $bid->shipping_cost = $product->shipping_cost;
        $bid->total_amount = ($request->amount + $product->shipping_cost);
        $bid->save();

        //Transaction

        // $transaction = new Transaction();
        // $transaction->user_id = $user->id;
        // $transaction->amount = getAmount($total_payable);
        // $transaction->post_balance = getAmount($user->balance);
        // $transaction->trx_type = '-';
        // $transaction->details = 'Bid to ' . $product->name;
        // $transaction->trx = getTrx();
        // $transaction->save();

        //Admin Notification
        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = $user->username . ' bid on '. $product->name;
        $adminNotification->click_url = urlPath('admin.users.bids.list',$user->id);
        $adminNotification->save();

        $data = [
            'bidder' => $bid->user->firstname . ' '. $bid->user->lastname,
            'amount' =>  $bid->bid_amount,
        ];

        event(new MyEvent($data));

        $notify[] = ['success', "Successfully bid on the product!"];
        return $notify;
    }

    //User bids list
    public function userBidsList()
    {
        $page_title = 'My Bids';
        $bids = Bid::where('user_id', auth()->id())->with('product')->latest()->paginate(getPaginate());
        return view(activeTemplate() . 'user.bids.bids_list', compact('page_title', 'bids'));
    }

    //User Winning Products
    public function winningProducts()
    {
        $page_title = 'Winning Products';
        $winners = Winner::where('user_id', auth()->id())->with('bid')->latest()->paginate(getPaginate());
        return view(activeTemplate() . 'user.bids.winners_list', compact('page_title', 'winners'));
    }
}
