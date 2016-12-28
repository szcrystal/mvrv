<?php 
/* Here is mail view */
?>
@if($is_user)
{{$name}}　様
<br /><br />
{!! nb($info->mail_register) !!}

<br />
<br />
▼プロフィールの確認／編集はこちら<br />
<a href="{{getUrl('profile/'.$user_number)}}">{{getUrl('profile/'.$user_number)}}</a>
<br /><br /><br />
<br /><br /><br />

{!! nb($info->mail_footer) !!}
<br /><br />

@else
{{$name}}様より、ユーザー登録がありました。<br />
頂きました内容は下記となります。<br /><br />

▼{{$name}}様の登録内容はこちらより確認できます。<br />
<a href="{{getUrl('dashboard/show-profile/'.$id)}}">{{ getUrl('dashboard/show-profile/'.$id) }}</a>
<br /><br /><br />
<br /><br /><br />

{!! nb($info->mail_footer) !!}
<br /><br />

@endif

