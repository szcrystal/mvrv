

<p>
    パスワードリセット用のリンクは以下となります。<br>
    有効時間の{{ config('auth.expire') }}分以内にクリックをしてパスワードをリセットして下さい。
</p>

<a href="{{ $actionUrl }}" class="button" target="_blank">
{{ $actionUrl }}
</a>

<br>
<br>
<br>
<br>
___________________________
<br>
{{ env('ADMIN_NAME', 'MovieReview') }}


