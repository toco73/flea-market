@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/chat.css')}}">
@endsection
@section('content')
<div class="transaction-chat-container" id="chat-app" data-item-id="{{ $item->id }}">
    <div class="chat-main-content">
        
        {{-- 左側：サイドバー --}}
        <div class="sidebar">
            <p class="sidebar-title">その他の取引</p>
            <ul class="other-transaction-list">
                @foreach($otherTransactions as $otherItem)
                    <li class="other-transaction-item">
                        {{-- 他の取引チャットへのリンク --}}
                        <a href="{{ route('transaction.chat', $otherItem->id) }}" class="transaction-link">
                            <span class="otheritem">{{ $otherItem->name }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- 右側：メインチャットエリア --}}
        <div class="main-chat-area">
            
            {{-- ヘッダー：相手の名前と取引完了ボタン --}}
            <div class="chat-partner-info">
                <div class="user-icon-circle">
                    @if($partnerIcon)
                        <img src="{{ asset('storage/' . $partnerIcon) }}" alt="partner-icon">
                    @else
                        <div class="default-icon"></div> {{-- 画像がない時のグレーの円 --}}
                    @endif
                </div>
                <h3 class="partner-name">「{{ $partnerName }}」さんとの取引画面</h3>
                
                {{-- 黄緑枠：購入者のみに表示するロジック --}}
                @if($isBuyer)
                    <div class="transaction-actions">
                        <button class="btn btn-complete" type="button" onclick="openRatingModal()">取引を完了する</button>
                    </div>
                @endif
            </div>
            
            {{-- 商品詳細 --}}
            <div class="item-detail-area">
                <img src="{{ asset('storage/' . $item->image) }}" class="item-image">
                <div class="item-info">
                    <p class="item-name">{{ $item->name }}</p>
                    <p class="item-price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>

            {{-- オレンジ枠：チャット表示エリア --}}
            <div class="chat-messages" id="message-list">
                @foreach($messages as $msg)
                    {{-- メッセージごとに自分のものか判定 --}}
                    @php $isMine = ($msg->user_id === Auth::id()); @endphp

                    <div class="message-wrapper {{ $isMine ? 'my-message' : 'partner-message' }}" id="msg-{{ $msg->id }}">
                        
                        {{-- アイコンの丸枠 --}}
                        <div class="user-icon-circle small">
                            @if($isMine)
                                @if(Auth::user()->profile->icon_path)
                                    <img src="{{ asset('storage/' . Auth::user()->profile->icon_path) }}">
                                @else
                                    <div class="default-icon"></div>
                                @endif
                            @else
                                @if($partnerIcon)
                                    <img src="{{ asset('storage/' . $partnerIcon) }}">
                                @else
                                    <div class="default-icon"></div>
                                @endif
                            @endif
                            
                        </div>

                        <div class="message-body {{ $isMine ? 'my-message' : 'partner-message' }}">
                            {{-- ユーザー名の表示 --}}
                            <div class="user-name">
                                <span>{{ $isMine ? $profile->username : $partnerName }}</span>
                            </div>

                            <div class="message-bubble">
                                <p class="message-text">{{ $msg->message }}</p>
                            </div>

                            {{-- 編集・削除ボタン：自分のメッセージのみ表示 --}}
                            @if($isMine)
                                <div class="message-options">
                                    <button type="button" class="opt-btn edit-btn" onclick="editMessage({{ $msg->id }})">編集</button>
                                    <button type="button" class="opt-btn delete-btn" onclick="deleteMessage({{ $msg->id }})">削除</button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- 入力フォーム --}}
            <div class="chat-input-area">
                <form action="{{route('chat.send',['item_id' => $item->id])}}" id="chat-form" method="post">
                    @csrf
                    <div class="chat-flex">
                        <input  type="text" name="message" class="message-input" id="message-input" placeholder="取引メッセージを記入してください">
                        <div class="error-message">
                            @error('message')
                                {{$message}}
                            @enderror
                        </div>
                        <div class="input-actions">
                            <input type="file" name="image" id="fileImage">
                            <label class="add-image-label" for="fileImage">画像を追加</label>
                            <div class="error-message">
                                @error('image')
                                    {{$message}}
                                @enderror
                            </div>
                            <button type="submit" class="opt-btn">
                                <img class="send-button" src="{{asset('storage/icons/send.jpg')}}" alt="">
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="ratingModal" class="modal-overlay">
                <div class="modal-content">
                    <p class="modal-title">取引が完了しました。</p>
                    <p class="modal-text">今回の取引相手はどうでしたか？</p>
                    
                    <form action="{{ route('transaction.complete', $item->id) }}" method="POST">
                        @csrf
                        <div class="star-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star" data-value="{{ $i }}">&#9733;</span>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-value" value="">
                        <button type="submit" class="btn star-send">
                            送信する
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let lastMessageId = {{ $messages->last()->id ?? 0 }};

document.addEventListener('DOMContentLoaded', function () {
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const messageList = document.getElementById('message-list');
    const itemId = document.getElementById('chat-app').dataset.itemId;
    const storageKey = `chat_draft_${itemId}`;
    const authUserId = {{ Auth::id() }};

    //下書き復元
    const savedMessage = localStorage.getItem(storageKey);
    if (savedMessage) {
        messageInput.value = savedMessage;
    }

    //下書き保存
    messageInput.addEventListener('input', () => {
        localStorage.setItem(storageKey, messageInput.value);
    });

    //送信処理
    chatForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        const message = messageInput.value;
        if(!message.trim()) return;

        try{
            const response = await fetch(`/transaction/chat/${itemId}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept' : 'application/json'
                },
                body: JSON.stringify({ message })
            });

            if (response.status === 422){
                const errorData = await response.json();
                alert(errorData.errors.message[0]);
                return;
            }

            if(response.ok){
                const data = await response.json();
                appendMessage(data, 'my-message');
                messageInput.value = '';
                localStorage.removeItem(storageKey);
                messageList.scrollTop = messageList.scrollHeight;
                lastMessageId = data.id;
            }
        }catch(error){
            console.error('Error:', error);
        } 
    });

    //ポーリング受信
    async function fetchNewMessages(){
        try{
            const response = await fetch(`/transaction/chat/${itemId}/fetch?last_id=${lastMessageId}`);
            const messages = await response.json();

            messages.forEach(msg => {
                if(msg.id > lastMessageId){
                    const className = (msg.user_id === authUserId) ? 'my-message' : 'partner-message';
                    appendMessage(msg,className);
                    lastMessageId = msg.id;
                }
            });
        }catch(error){
            console.error('Fetch error:',error);
        }
    }

    //3秒ごとに新着確認
    setInterval(fetchNewMessages,3000);

    // --- メッセージ追加用関数 ---
    function appendMessage(data, className) {
        //重複防止
        if(document.getElementById(`msg-${data.id}`)) return;

        const div = document.createElement('div');
        div.className = `message-wrapper ${className}`;
        div.id = `msg-${data.id}`;
        
        // 自分が送った場合のみ「編集・削除」を表示
        const options = (className === 'my-message') ? `
            <div class="message-options">
                <button class="opt-btn" onclick="editMessage(${data.id})">編集</button>
                <button class="opt-btn" onclick="deleteMessage(${data.id})">削除</button>
            </div>` : '';

        div.innerHTML = `
            <div class="message-body">
                <div class="message-bubble">
                    <p class="message-text">${data.message}</p>
                </div>
                ${options}
            </div>
        `;
        messageList.appendChild(div);
        messageList.scrollTop = messageList.scrollHeight;
    }
});

//編集・削除の実装
function editMessage(id) {
    const msgElement = document.querySelector(`#msg-${id} .message-text`);
    const originalText = msgElement.innerText;
    const newText = prompt("メッセージを編集してください:", originalText);

    if (newText && newText !== originalText) {
        fetch(`/transaction/chat/message/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: newText })
        })
        .then(res => res.ok && (msgElement.innerText = newText));
    }
}

function deleteMessage(id) {
    if (confirm("本当に削除しますか？")) {
        fetch(`/transaction/chat/message/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(res => res.ok && document.getElementById(`msg-${id}`).remove());
    }
}

//モーダル
function openRatingModal(){
    const modal = document.getElementById('ratingModal');
    if(modal){
        modal.style.display = 'flex';
    }else{
        console.error('Rating modal element not found');
    }
}
document.querySelectorAll('.star').forEach(star => {
    star.addEventListener('click', function() {
        const value = this.getAttribute('data-value');
        document.getElementById('rating-value').value = value;

        // 全ての星から一度 active を消し、選択された数まで再度付与する
        document.querySelectorAll('.star').forEach(s => {
            const starValue = s.getAttribute('data-value');
            if (starValue <= value) {
                s.classList.add('active');
            } else {
                s.classList.remove('active');
            }
        });
    });
});
</script>
@endsection