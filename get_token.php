<?php
// 先程取得した認可コードを入れてください
define('CODE',"w1cImcZh");
define('APPID', 'dj00aiZpPUVKV3J4MGZWYkEzMyZzPWNvbnN1bWVyc2VjcmV0Jng9NTk-');
define('SECRET', 'a8mx7pufdFZXe41FSZIw4vuKLOLKAerdXk9IYxc6');
/**
 * 大きな流れ
 * アクセストークンの取得方法（v1）
 * https://developer.yahoo.co.jp/webapi/shopping/help.html#accesstoken
 * ー トークン取得の流れ
 *  1. 「Authorizationエンドポイント」にリクエストする。
 *  2. リダイレクトされたペ－ジのパラメータから「認可コード（code）」を取得する。
 *  ******************
 *  ここから再開です
 *  ******************
 *  3. 「Tokenエンドポイント」にリクエストをしてトークン情報を取得する。
 *  ※トークン情報の中に"アクセストークン"が含まれます。
 *
 *  この順番で実施していきます
 */

/**
 * 3. 「Tokenエンドポイント」にリクエストをしてトークン情報を取得する。
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
    'code'         => CODE,
    'grant_type'   => 'authorization_code',
    'redirect_uri' => CALLBACK_URL,
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
$keys = ["access_token", "id_token", "refresh_token"];
foreach($keys as $key) {
    echo "$key: $token[$key]" . PHP_EOL;
}
