<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Item;
use App\Models\User;
use App\Events\MessageSent;
use App\Http\Requests\ChatMessageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    //取引中の商品
    public function showChat($itemId){
        $user = Auth::user();
        $profile = $user->profile;
        $item = Item::with(['seller.profile','buyer.profile'])->findOrFail($itemId);

        $otherTransactions = Item::where('status', 'in_progress')
                ->where('id', '!=', $itemId)
                ->where(function($query) use ($user) {
                     $query->where('seller_id', $user->id)
                        ->orWhere('buyer_id', $user->id);
                })
                ->get();
        
        $isSeller = ($item->seller_id === $user->id); 
        $isBuyer = ($item->buyer_id === $user->id);
        
        if (!$isSeller && !$isBuyer) {
            abort(403);
        }

        if ($isSeller){
            $partnerName = $item->buyer->profile->username ?? '';
            $partnerIcon = $item->buyer->profile->icon_path ?? null;
        }else{
            $partnerName = $item->seller->profile->username ?? '';
            $partnerIcon = $item->seller->profile->icon_path ?? null;
        }

        $messages = ChatMessage::where('item_id', $itemId)
                    ->orderBy('created_at', 'asc') // 古い順に並べる
                    ->get();

        return view('chat', compact('profile','item', 'otherTransactions','isSeller', 'isBuyer','partnerName','partnerIcon','messages'));
    }

    public function sendMessage(ChatMessageRequest $request, $itemId)
    {
        $validated = $request->validated();

        $message = ChatMessage::create([
            'item_id' => $itemId,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        $message->load('user.profile');

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    // メッセージ更新
    public function updateMessage(Request $request, $id)
    {
        $message = ChatMessage::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $message->update(['message' => $request->message]);
        return response()->json(['status' => 'success']);
    }

    // メッセージ削除
    public function destroyMessage($id)
    {
        $message = ChatMessage::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $message->delete();
        return response()->json(['status' => 'success']);
    }
}
