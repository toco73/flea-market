require('./bootstrap');

window.Echo.channel('chat')
    .listen('MessageSent', (e) => {
        console.log('New message:', e.message);
        // ここでDOM操作をして、チャット画面にメッセージを追加する
    });