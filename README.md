# 実践学習ターム 模擬案件初級_フリマアプリ
## 環境構築
### Dockerビルド
  1. git clone git@github.com:toco73/check-test2.git  
  2. DockerDesktopアプリを立ち上げる  
  3. docker compose up -d --build  
 ＊MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせてdocker-compose.ymlファイルを編集してください。

 ### Laravel環境構築
  1. docker compose exec php bash  
  2. composer install
   
  3. .env.exsampleファイルから.envを作成し、以下の環境変数を変更追加  
     DB_CONNECTION=mysql  
     DB_HOST=mysql  
     DB_PORT=3306  
     DB_DATABASE=laravel_db  
     DB_USERNAME=laravel_user  
     DB_PASSWORD=laravel_pass
     
　4.アプリケーションキーの作成   
　　　php artisan key:generate
   
　5.マイグレーションの実行  
  　　php artisan migrate
    
　6.シーディングの実行  
　　php artisan db:seed  

## メール認証
mailtrapというツールを使用しています。<br>
以下のリンクから会員登録をしてください。　<br>
https://mailtrap.io/

メールボックスのIntegrationsから 「laravel 7.x and 8.x」を選択し、　<br>
.envファイルのMAIL_MAILERからMAIL_ENCRYPTIONまでの項目をコピー＆ペーストしてください。　<br>
MAIL_FROM_ADDRESSは任意のメールアドレスを入力してください。　

## Stripeについて
コンビニ支払いとカード支払いのオプションがありますが、決済画面にてコンビニ支払いを選択しますと、レシートを印刷する画面に遷移します。そのため、カード支払いを成功させた場合に意図する画面遷移が行える想定です。<br>

また、StripeのAPIキーは以下のように設定をお願いいたします。
```
STRIPE_PUBLIC_KEY="パブリックキー"
STRIPE_SECRET_KEY="シークレットキー"
```

以下のリンクは公式ドキュメントです。<br>
https://docs.stripe.com/payments/checkout?locale=ja-JP

## リアルタイム通信
pusherというツールを使用しています。<br>
以下のリンクからアカウントを作成してください。<br>
https://pusher.com/

.envファイルにAPIキーは以下のように設定をお願いいたします。
```
PUSHER_APP_ID="your-app-id"
PUSHER_APP_KEY="your-app-key"
PUSHER_APP_SECRET="your-app-secret"
PUSHER_APP_CLUSTER="your-app-cluster"
```
以下のリンクは公式ドキュメントです。<br>
https://www.issoh.co.jp/tech/details/2931/#Pusher
     
## 使用技術(実行環境)
　・PHP7.4.9  
  　・Laravel8.83.29  
 　・MySQL8.0.26  

## ER図
<img width="891" height="1021" alt="er-diagram" src="https://github.com/user-attachments/assets/788626fd-793d-4cc8-bbee-7f6e4ef47226" />


## URL
・開発環境：http://localhost/  
・phpMyAdmin：http://localhost:8080/
