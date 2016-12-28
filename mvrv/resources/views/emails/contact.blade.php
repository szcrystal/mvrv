<?php 
/* Here is mail view */
?>

<?php //$info = DB::table('siteinfos')->first(); ?>

@if($is_user)
{{$name}}　様
<br /><br />
お問い合わせの送信が完了しました。<br>
頂きました内容は下記となります。

{{--
{!! nl2br($info->mail_contact) !!}
--}}

<br />
………………………………………………………………………………………
<br /><br />

◆お名前<br />
{{$name}}<br /><br />

◆メールアドレス<br />
{{$email}}<br /><br />

◆お問い合わせ内容<br />
{!! nl2br($context) !!}
<br /><br /><br /><br />

{{--
{!! nl2br($info->mail_footer) !!}
--}}
<br /><br />

@else
{{$name}}様より、お問い合わせがありました。<br />
頂きました内容は下記となります。<br />

<br />
………………………………………………………………………………………
<br /><br />

◆お名前<br />
{{$name}}<br /><br />

◆メールアドレス<br />
{{$email}}<br /><br />

◆お問い合わせ内容<br />
{!! nl2br($context) !!}
<br /><br /><br /><br />

{{--
{!! nl2br($info->mail_footer) !!}
--}}

<br /><br />

@endif
