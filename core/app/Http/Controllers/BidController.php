<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Bid;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Winner;
use Illuminate\Http\Request;

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
        if ($_existing_user_bid){
            $_old_bid_amount = $_existing_user_bid->bid_amount;
            $_old_shipping_cost = $_existing_user_bid->shipping_cost;
            $_old_amount = $_old_bid_amount + $_old_shipping_cost;
            $total_payable = ($request->amount + $product->shipping_cost) - $_old_amount;

            //Exist bid object
            $bid = $_existing_user_bid;
        } else {
            $total_payable = $request->amount + $product->shipping_cost;

            //Creating bid object if not exist
            $bid = new Bid();
        }

        // Subtract User balance
        $user = auth()->user();
        if ($user->balance < $total_payable){
            $notify[] = ['error', __("You don't have enough balance! Please deposit and bid again.")];
            return back()->withNotify($notify);
        }
        $user->balance -= $total_payable;
        $user->save();

        //Bid
        $bid->product_id = $product_id;
        $bid->user_id = $user->id;
        $bid->bid_amount = $request->amount;
        $bid->shipping_cost = $product->shipping_cost;
        $bid->total_amount = ($request->amount + $product->shipping_cost);
        $bid->save();

        //Transaction
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = getAmount($total_payable);
        $transaction->post_balance = getAmount($user->balance);
        $transaction->trx_type = '-';
        $transaction->details = 'Bid to ' . $product->name;
        $transaction->trx = getTrx();
        $transaction->save();

        //Admin Notification
        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = $user->username . ' bid on '. $product->name;
        $adminNotification->click_url = urlPath('admin.users.bids.list',$user->id);
        $adminNotification->save();

        $notify[] = ['success', "Successfully bid on the product!"];
        return back()->withNotify($notify);
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
