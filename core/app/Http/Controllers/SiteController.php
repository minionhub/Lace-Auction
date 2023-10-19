<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\Product;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;


class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }


        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $data['page_title'] = 'Home';
        $data['sections'] = Page::where('tempname',$this->activeTemplate)->where('slug','home')->firstOrFail();
        return view($this->activeTemplate . 'home', $data);
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $data['page_title'] = $page->name;
        $data['sections'] = $page;
        return view($this->activeTemplate . 'pages', $data);
    }


    public function contact()
    {
        $contact_content = getContent('contact.content', true);
        $address_content = getContent('address.content', true);
        $page_title = "Contact Us";
        return view($this->activeTemplate . 'contact', compact('contact_content', 'address_content', 'page_title'));
    }


    public function contactSubmit(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();

        $imgs = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'attachments' => [
                'sometimes',
                'max:4096',
                function ($attribute, $value, $fail) use ($imgs, $allowedExts) {
                    foreach ($imgs as $img) {
                        $ext = strtolower($img->getClientOriginalExtension());
                        if (($img->getSize() / 1000000) > 2) {
                            return $fail("Images MAX  2MB ALLOW!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf images are allowed");
                        }
                    }
                    if (count($imgs) > 5) {
                        return $fail("Maximum 5 images can be uploaded");
                    }
                },
            ],
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket->user_id = auth()->id();
        $ticket->name = $request->name;
        $ticket->email = $request->email;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->id() ? auth()->id() : 0;
        $adminNotification->title = 'New support ticket has opened';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $path = imagePath()['ticket']['path'];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $image) {
                try {
                    $attachment = new SupportAttachment();
                    $attachment->support_message_id = $message->id;
                    $attachment->image = uploadImage($image, $path);
                    $attachment->save();

                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Could not upload your ' . $image];
                    return back()->withNotify($notify)->withInput();
                }

            }
        }
        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return response()->json('Cookie accepted successfully');
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function blog(){
        $blogs = Frontend::where('data_keys','blog.element')->latest()->paginate(getPaginate());

        $page_title = 'Blogs';
        return view($this->activeTemplate.'blog',compact('blogs','page_title'));
    }

    public function blogDetails($id,$slug){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $blog->increment('views');

        $latest_blogs = Frontend::where('data_keys','blog.element')->where('id', '!=', $id)->latest()->take(5)->get();

        $page_title = __('Blog Details');
        return view($this->activeTemplate.'blogDetails',compact('blog','page_title', 'latest_blogs'));
    }

    public function extraPageDetails($id,$slug){
        $extra = Frontend::where('id',$id)->where('data_keys','extra.element')->firstOrFail();

        $page_title = $extra->data_values->title;
        return view($this->activeTemplate.'extraPageDetails',compact('extra','page_title'));
    }

    public function placeholderImage($size = null){
        if ($size != 'undefined') {
            $size = $size;
            $imgWidth = explode('x',$size)[0];
            $imgHeight = explode('x',$size)[1];
            $text = $imgWidth . '×' . $imgHeight;
        }else{
            $imgWidth = 150;
            $imgHeight = 150;
            $text = 'Undefined Size';
        }
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    // Auction Details
    public function auctionDetails($product_id, $slug)
    {
        $product = Product::with(['bids', 'category'])->findOrFail($product_id);

        $page_title = 'Auction Details';
        return view($this->activeTemplate.'products.auctionDetails',compact('product','page_title'));
    }

    // Category Products
    public function categoryProducts($category_id, $slug)
    {
        $products = Product::with(['bids', 'category'])->where('category_id', $category_id)->get();

        $page_title = 'Category Products';
        return view($this->activeTemplate.'products.products',compact('products','page_title'));
    }

    // Search Products
    public function searchProduct(Request $request)
    {
        $request->validate([
            'product' => 'required|string'
        ]);

        $search = $request->product;
        $products = Product::with(['bids', 'category'])->where('name', 'LIKE', "%{$search}%")->get();

        $page_title = "Search Result {{$search}}";
        return view($this->activeTemplate.'products.products',compact('products','page_title'));
    }

    //Products
    public function liveAuction()
    {
        $live_auction_content = getContent('live_auction.content', true);
        $live_products = Product::running()->with(['category', 'bids'])->latest()->paginate(getPaginate());

        $page_title = 'Live Auction';
        return view($this->activeTemplate.'products.live_auction',compact('live_products','live_auction_content', 'page_title'));
    }

    public function closedAuction()
    {
        $closed_auction_content = getContent('closed_auction.content', true);
        $expired_products = Product::expired()->with('category')->latest()->paginate(getPaginate());

        $page_title = 'Closed Auction';
        return view($this->activeTemplate.'products.closed_auction',compact('expired_products','closed_auction_content', 'page_title'));
    }
}
