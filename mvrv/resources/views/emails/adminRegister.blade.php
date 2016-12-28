<?php 
/* Here is mail view */
$info = DB::table('siteinfos')->first();
?>
{{$name}} さんが woman x auditor の管理者として登録されました。<br />
これより管理画面の操作が可能となります。
<br /><br />
◆ID(メールアドレス)<br />
{{ $email }}<br /><br />

◆パスワード<br />
{{ $password }}

<br /><br /><br />
▼管理画面のURLはこちら<br />
<a href="{{getUrl('dashboard')}}">{{ getUrl('dashboard/') }}</a>
<br /><br />
上記のIDとパスワードを入力してご利用下さい。

<br /><br /><br /><br /><br />
{!! nb($info->mail_footer) !!}
<br /><br />


