<?php
define('APPID', 'dj00aiZpPUVKV3J4MGZWYkEzMyZzPWNvbnN1bWVyc2VjcmV0Jng9NTk-');
/**
 * 大きな流れ
 * アクセストークンの取得方法（v1）
 * https://developer.yahoo.co.jp/webapi/shopping/help.html#accesstoken
 * ー トークン取得の流れ
 *  1. 「Authorizationエンドポイント」にリクエストする。
 *  2. リダイレクトされたペ－ジのパラメータから「認可コード（code）」を取得する。
 *  3. 「Tokenエンドポイント」にリクエストをしてトークン情報を取得する。
 *  ※トークン情報の中に"アクセストークン"が含まれます。
 *
 *  この順番で実施していきます
 */

/**
 *  1. 「Authorizationエンドポイント」にリクエストする。
 * Authorization エンドポイントは下記へアクセスすると、
 * https://auth.login.yahoo.co.jp/yconnect/v2/.well-known/openid-configuration
 * 下記の値であることがわかります。これはまあ固定値と思ってしまって良いので、定数にしときます
 * "authorization_endpoint": "https://auth.login.yahoo.co.jp/yconnect/v2/authorization",
 */
define('AUTHORIZATION_URL', 'https://auth.login.yahoo.co.jp/yconnect/v2/authorization');

/**
 * 次はAuthorizationエンドポイントのリファレンスです
 * https://developer.yahoo.co.jp/yconnect/v2/hybrid/authorization.html
 * 今回、「認可コード」を取得します。
 * リファレンスではパラメータとして
 * https://auth.login.yahoo.co.jp/yconnect/v1/authorization?response_type=code&client_id=<アプリケーションID>&redirect_uri=https%3A%2F%2Fwww.yahoo.co.jp%2F&scope=openid+profile&bail=1
 * のようにリクエストしてくださいとありますので（v1になってるけど）
 * それに従ってリクエストするURLを生成します
 */
$query = http_build_query(
    [
        "response_type" => "code token",
        "client_id" => APPID,
        "redirect_uri" => "http://localhost", // とりあえず。コールバックURLにいれとく必要があります
        "scope" => "openid",
    ], "", "&", PHP_QUERY_RFC3986
);
$url = AUTHORIZATION_URL . "?" . $query;
echo "ここで出てきたURLを貼り付けてブラウザに貼ります" . PHP_EOL;
echo $url;

/**
 * 2. リダイレクトされたペ－ジのパラメータから「認可コード（code）」を取得する。
 * http://localhost/#access_token=QNIHZyFk....&&token_type=Bearer&expires_in=3600&code=PPLmDh8T
 * この code=PPLmDh8T がわかればOKです
 * このコードを次のプログラムに渡しましょう
 */



/**
 * 3. 「Tokenエンドポイント」にリクエストをしてトークン情報を取得する。
 * 同様に、Tokenエンドポイントは下記が最新です
 *   "token_endpoint": "https://auth.login.yahoo.co.jp/yconnect/v2/token",
 */
define('TOKEN_ENDPOING_URL', 'https://auth.login.yahoo.co.jp/yconnect/v2/token');

/*


// https://developer.yahoo.co.jp/webapi/shopping/help.html#accesstoken
function generateToken($key, $secret) {
  $tokenUrl = 'https://auth.login.yahoo.co.jp/yconnect/v1/token';
  $header = [
      'Content-Type: application/x-www-form-urlencoded',
      'Authorization: Basic ' . base64_encode($key .  ':' . $secret),
  ];

}


$key = "dj00aiZpPUVKV3J4MGZWYkEzMyZzPWNvbnN1bWVyc2VjcmV0Jng9NTk-";
$secret = "a8mx7pufdFZXe41FSZIw4vuKLOLKAerdXk9IYxc6";

$token = generateToken($key, $secret);


// https://developer.yahoo.co.jp/webapi/shopping/stock/sample.html#setStock
$header = [
    'POST /ShoppingWebService/V1/setStock HTTP/1.1',
    'Host: circus.shopping.yahooapis.jp',
    'Authorization: Bearer ' . ＜アクセストークン＞
];

$url   = 'https://circus.shopping.yahooapis.jp/ShoppingWebService/V1/setStock';
$param = array(
            "seller_id" => '9999999',
            "item_code" => 'xxxxx',
            "quantity"  => '10',
        );

// 必要に応じてオプションを追加してください。
$ch = curl_init();
curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER,     $header);
curl_setopt($ch, CURLOPT_URL,            $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST,           true);
curl_setopt($ch, CURLOPT_POSTFIELDS,     http_build_query($param));

$response = curl_exec($ch);
curl_close($ch);
 */
?>
