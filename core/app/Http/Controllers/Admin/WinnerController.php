<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Winner;
use Illuminate\Http\Request;

class WinnerController extends Controller
{
    //Bids List
    public function bidsList()
    {
        $page_title = 'Bids';
        $empty_message = 'No result found';
        $bids = Bid::with(['user', 'product'])->latest()->paginate(getPaginate());
        return view('admin.bids.bids-list', compact('page_title', 'bids', 'empty_message'));
    }

    // Winners
    public function allWinners()
    {
        $page_title = 'Winners & Items';
        $empty_message = 'No result found';
        $winners = Winner::with(['user', 'bid'])->latest()->paginate(getPaginate());
        return view('admin.bids.winners-list', compact('page_title', 'winners', 'empty_message'));
    }

    public function pendingWinners()
    {
        $page_title = 'Pending Products';
        $empty_message = 'No result found';
        $winners = Winner::where('shipping_status', 0)->with(['user', 'bid'])->latest()->paginate(getPaginate());
        return view('admin.bids.winners-list', compact('page_title', 'winners', 'empty_message'));
    }

    public function processingWinners()
    {
        $page_title = 'Processing Products';
        $empty_message = 'No result found';
        $winners = Winner::where('shipping_status', 1)->with(['user', 'bid'])->latest()->paginate(getPaginate());
        return view('admin.bids.winners-list', compact('page_title', 'winners', 'empty_message'));
    }

    public function shippedWinners()
    {
        $page_title = 'Shipped Products';
        $empty_message = 'No result found';
        $winners = Winner::where('shipping_status', 2)->with(['user', 'bid'])->latest()->paginate(getPaginate());
        return view('admin.bids.winners-list', compact('page_title', 'winners', 'empty_message'));
    }

    public function statusUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1,2'
        ]);

        $status = $request->status;

        $winner = Winner::findOrFail($id);
        $winner->shipping_status = $status;
        $winner->save();

        if ($status == 0){
            notify($winner->user, 'PENDING_PRODUCT', [
                'product_name' => $winner->bid->product->name,
                'product_link' => route('auction.details', [$winner->bid->product_id, slug($winner->bid->product->name)])
            ]);
        }elseif ($status == 1){
            notify($winner->user, 'PROCESSING_PRODUCT', [
                'product_name' => $winner->bid->product->name,
                'product_link' => route('auction.details', [$winner->bid->product_id, slug($winner->bid->product->name)])
            ]);
        }elseif ($status == 2){
            notify($winner->user, 'SHIPPED_PRODUCT', [
                'product_name' => $winner->bid->product->name,
                'product_link' => route('auction.details', [$winner->bid->product_id, slug($winner->bid->product->name)])
            ]);
        }

        $notify[] = ['success', 'Status updated!'];
        return back()->withNotify($notify);
    }
}
