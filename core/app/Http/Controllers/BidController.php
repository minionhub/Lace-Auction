<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Bid;
use App\Models\ProxyBid;
use App\Models\User;
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


        // proxy bidding
        if ($request->proxyBidding == 'on') {
            // previous proxy
            $previous = ProxyBid::where('product_id', $product_id)->first(); 
            //previous proxy exist
            if ($previous) {
                // same user, update proxy
                if ($previous->user_id == $user->id) {
                        // updated proxy
                        // Update($previous->amount, $request->amount);
                        $previous->amount = $request->amount;
                        $previous->save();
                }
                // change proxy
                else {
                    $previous_user = User::where('id', $previous->user_id)->first();
                    if ($previous->amount < $request->amount) {
                        // Delete($previous);
                        $previous->delete();
                        // Bid($previous->amount);
                        $this->placeBid($product_id, $product, $previous_user, $previous->amount);

                        if ($request->amount > $previous->amount + 10) {
                            // Create($request);
                            $this->storeProxyBid($product_id, $user->id, $request->amount);
                            // Bid($request->amount + 10);
                            $this->placeBid($product_id, $product, $user, $previous->amount + 10, $user->id);
                        }
                        else
                            // Bid($request->amount);
                            $this->placeBid($product_id, $product, $user, $request->amount);
                    } else {
                        // Bid($request->amount);
                        $this->placeBid($product_id, $product, $user, $request->amount);

                        if ($previous->amount > $request->amount + 10)
                            // Bid($request->amount + 10);
                            $this->placeBid($product_id, $product, $previous_user, $request->amount + 10, $previous_user->id);
                        else {
                            // Delete($previous);
                            $previous->delete();
                            // Bid($previous->amount);
                            $this->placeBid($product_id, $product, $previous_user, $previous->amount);
                        }
                    }
                }
            } else {
                //previous proxy doesn't exist, regist new proxy
                $currentMaxBid = ($product->bids->last()->bid_amount ?? $product->min_bid_price);
                if($request->amount > $currentMaxBid + 10) {
                    // Create($request);
                    $this->storeProxyBid($product_id, $user->id, $request->amount);

                    if ($product->bids->last()->user_id != $user->id)
                        $this->placeBid($product_id, $product, $user, $currentMaxBid + 10, $user->id);
                    else {
                        $data = [
                            'isProxy' => $user->id,
                        ];
                        event(new MyEvent($data));
                    }

                } else {
                    if ($product->bids->last()->user_id == $user->id) {
                        $this->storeProxyBid($product_id, $user->id, $request->amount);

                        $data = [
                            'isProxy' => $user->id,
                        ];
                        event(new MyEvent($data));
                    } else
                        $this->placeBid($product_id, $product, $user, $request->amount);
                }
            }
        }






        // normal bidding 
        else {
            // previous proxy
            $previous = ProxyBid::where('product_id', $product_id)->first(); 
            if ($previous) {
                if ($request->amount < $previous->amount) {
                    // Bid($request->amount);
                    $this->placeBid($product_id, $product, $user, $request->amount);
                    if ($user->id != $previous->user_id) {
                        $previous_user = User::where('id', $previous->user_id)->first();
                        if ($previous->amount > $request->amount + 10) {
                            // Bid($request->amount + 10);
                            $this->placeBid($product_id, $product, $previous_user, $request->amount + 10, $previous_user->id);
                        } else {
                            // Delete($previous);
                            $previous->delete();
                            // Bid($previous->amount);
                            $this->placeBid($product_id, $product, $previous_user, $previous->amount);
                        }
                    } else {
                        $data = [
                            'isProxy' => $user->id,
                        ];
                        event(new MyEvent($data));
                    }
                } else {
                    // Delete($previous);
                    $previous->delete();

                    if ($user->id != $previous->user_id) {
                        // Bid($previous->amount);
                        $previous_user = User::where('id', $previous->user_id)->first();
                        $this->placeBid($product_id, $product, $previous_user, $previous->amount);
                    }
                    $this->placeBid($product_id, $product, $user, $request->amount);
                }
            } else {
                // normal bidding without proxy bidding
                // Bid($request->amount);
                $this->placeBid($product_id, $product, $user, $request->amount);
            }
        }

        $notify[] = ['success', "Successfully bid on the product!"];
        return $notify;
    }

    public function storeProxyBid($product_id, $user_id, $amount) {
        $proxy = new ProxyBid();
        $proxy->product_id = $product_id;
        $proxy->user_id = $user_id;
        $proxy->amount = $amount;
        $proxy->save();
    }


    public function placeBid($product_id, $product, $user, $amount, $isProxy = 0) {
        //Bid
        $bid = new Bid();
        $bid->product_id = $product_id;
        $bid->user_id = $user->id;
        $bid->bid_amount = $amount;
        $bid->shipping_cost = $product->shipping_cost;
        $bid->total_amount = ($amount + $product->shipping_cost);
        $bid->save();
        
        //Admin Notification
        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = $user->username . ' bid on '. $product->name;
        $adminNotification->click_url = urlPath('admin.users.bids.list',$user->id);
        $adminNotification->save();

        $data = [
            'bidder' => $bid->user->firstname . ' '. $bid->user->lastname,
            'amount' =>  intval($bid->bid_amount),
            'isProxy' => $isProxy,
        ];

        event(new MyEvent($data));
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
