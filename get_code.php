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
        "redirect_uri" => "http://localhost/get_token.php", // とりあえず。コールバックURLにいれとく必要があります
        "scope" => "openid",
    ], "", "&", PHP_QUERY_RFC3986
);
$url = AUTHORIZATION_URL . "?" . $query;
header("Location: $url");
echo $url;
exit;
