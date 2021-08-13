<?php
// 先程取得した refresh_token を入れてください
define('TOKEN',"Ay3uFWEBAJbczPUhLaR3Ra8CXMkh23O7bXU69ps4_EnQ1B4l5TpRp74xWLL5bcRGniYveKszoumOpcV2WIq1Y3xmQ_jTgbs7a5EJoFzUQYcy-X9CtHTdbs6kcok9mG7UfxD6H0POoGgRPbqIaOCy3qakYYZEkauJCbH8bnEQWg2aFyc1~1");
define('APPID', 'dj00aiZpPUVKV3J4MGZWYkEzMyZzPWNvbnN1bWVyc2VjcmV0Jng9NTk-');
define('SECRET', 'a8mx7pufdFZXe41FSZIw4vuKLOLKAerdXk9IYxc6');
/**
 * 「更新」する場合
 * 取得済みのトークン情報には「リフレッシュトークン（refresh_token）」が含まれています。
 * リフレッシュトークンをリクエストパラメータ"refresh_token"にセットをして
 * 「Tokenエンドポイント」にリクエストをしていただくと、更新されたトークン情報が返ってきます。
 *
 * 同様に、Tokenエンドポイントは下記が最新です
 *   "token_endpoint": "https://auth.login.yahoo.co.jp/yconnect/v2/token",
 *   サンプルコードと同様に$headerを指定してリクエストしていきます
 */
define('TOKEN_URL', 'https://auth.login.yahoo.co.jp/yconnect/v2/token');


// サンプルコードに合わせて名前をリネームしているだけです
define('CALLBACK_URL', 'http://localhost');

$header = [
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Basic ' . base64_encode(APPID . ':' . SECRET),
];

$param = [
    'refresh_token' => TOKEN,
    'grant_type'    => 'refresh_token',

];

// 任意でオプションの追加をしてください。
$ch = curl_init(TOKEN_URL);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST,           true);
curl_setopt($ch, CURLOPT_POSTFIELDS,     http_build_query($param));

$response = curl_exec($ch);
if (!$response) {
    var_dump(curl_error($ch));
    exit;
}
curl_close($ch);

// 任意でレスポンスデータの判定処理を追加してください。
$token = json_decode($response, true);

// 実行した結果は下記に別枠で記載しております。
$keys = ["access_token", "refresh_token"];
foreach($keys as $key) {
    echo "$key: $token[$key]" . PHP_EOL;
}
