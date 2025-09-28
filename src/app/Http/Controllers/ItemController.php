<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Comment;
use App\Models\Profile;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class ItemController extends Controller
{
    //商品一覧画面
    protected function index(Request $request){
        $tab = $request->query('tab','recommend');
        $keyword = $request->query('keyword');

        $items = collect();
        $myList = collect();

        if($tab === 'recommend'){
            $query = Item::query();

            if(auth()->check()){
                $query->where(function($q){
                    $q->whereNull('seller_id')
                    ->orWhere('seller_id','!=',auth()->id());
                });
            }

            if(!empty($keyword)){
                $query->where('name','like',"%{$keyword}%");
            }

            $items = $query->orderBy('created_at','desc')->get();
            
        }elseif($tab === 'mylist'){
            if(!auth()->check()){
                return redirect()->route('login');
            }

            $query = auth()->user()->likedItems();

            if(!empty($keyword)){
                $query->where('name','like',"%{$keyword}%");
            }
            $myList = $query->orderBy('created_at','desc')->get();
        }

        return view('index',compact('tab','items','myList','keyword'));
    }
    
    //商品詳細画面
    protected function show($itemId){
        $item = Item::withCount('likes')->with(['category','condition','comments.user.profile'])->findOrFail($itemId);
        $tab = null;
        $commentCount = $item->comments->count(); 
        return view('item',compact('item','tab','commentCount'));
    }
    
    //いいね機能
    protected function like(Item $item){
        auth()->user()->likedItems()->attach($item->id);
        return back();
    }
    public function unlike(Item $item){
        auth()->user()->likedItems()->detach($item->id);
        return back();
    }

    //コメント機能
    protected function comment(CommentRequest $request){
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $request->item_id,
            'content' => $request->content,
        ]);
        return back();
    }

    //商品購入画面
    public function purchaseShow($itemId){
        $item = Item::findOrFail($itemId);
        $tab = null;
        $profile = auth()->user()->profile;
        return view('purchase',compact('item','tab','profile'));
    }

    //購入処理
    public function purchaseStore(PurchaseRequest $request,$itemId){
        $item = Item::findOrFail($itemId);
        $paymentMethod = $request->payment_method;

        return redirect()->route('stripe.checkout', [
            'item_id' => $item->id,
            'payment_method' => $paymentMethod,
        ]);
    }

    //Stripe画面
    public function checkout(Request $request,$itemId){

        $item = Item::findOrFail($itemId);

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));

        $paymentMethod = $request->payment_method ?? 'カード払い';

        if($paymentMethod === 'コンビニ払い'){
            $stripePaymentMethod = 'konbini';
        }else{
            $stripePaymentMethod = 'card';
        }

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => [$stripePaymentMethod],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => ['name' => $item->name],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success',['item_id' => $item->id]),
            'cancel_url' => route('stripe.cancel'),
        ]);

        return redirect()->away($session->url);      
    }

    //決済完了後
    public function success(Request $request,$itemId){
        $item = Item::findOrFail($itemId);
        
        $item->buyer_id = auth()->id();
        $item->save();

        return redirect('/');
    }
    public function cancel(){
        return redirect('/purchase');
    }

    //送付先住所変更画面
    public function address($itemId){
        $item = Item::findOrFail($itemId);
        $tab = null;
        $profile = auth()->user()->profile;
        return view('address',compact('item','tab','profile'));
    }
    public function updateAddress(AddressRequest $request,$itemId){
        $item = Item::findOrFail($itemId);
        $profile = auth()->user()->profile;
        $profile->update([
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('purchase.show',$itemId);
    }

    //プロフィール画面
    public function mypage(Request $request){
        $profile = auth()->user()->profile;
        $user = Auth::user();
        $items = collect();
        $page = $request->query('page','sell');
        $tab = null;

        if($page === 'buy'){
            $items = Item::where('buyer_id',$user->id)->get();
        }elseif($page === 'sell'){
            $items = Item::where('seller_id',$user->id)->get();
        }
        return view('mypage',compact('profile','items','page','tab'));
    }

    //プロフィール編集画面
    public function edit(){
        $user = auth()->user();
        $profile = $user->profile;
        return view('profile',compact('profile'));
    }
    public function update(ProfileRequest $request){
        $user = $request->user();

        $data = $request->only(['username','post_code','address','building']);

        if($request->hasFile('icon_path')){
            $data['icon_path'] = $request->file('icon_path')->store('icons','public');
        }

        $profile = $user->profile()->updateOrCreate(['user_id' => $user->id],$data);

        return redirect('/');
    }

    //商品出品画面
    public function create(){
        $categories = Category::all();
        $conditions = Condition::all();
        $tab = null;

        return view('sell',compact('categories','conditions','tab'));
    }
    public function store(ExhibitionRequest $request){
        $image = $request->file('image')->store('items','public');

        Item::create([
            'image' => $image,
            'category_id' => $request->category_id,
            'condition_id' => $request->condition_id,
            'name' => $request->name,
            'brand_name' => $request->brand_name,
            'description' => $request->description,
            'price' => $request->price,
            'seller_id' => Auth::id(),
        ]);

        return redirect('/');
    }
}
