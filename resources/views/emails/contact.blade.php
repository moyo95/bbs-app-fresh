<x-mail::message>
@if ($role === 'admin')
# 新しいお問い合わせがありました

以下の内容でお問い合わせがありましたので、ご確認ください。

<x-mail::panel>
**お名前:** {{ $contact['name'] }}<br>
**メールアドレス:** {{ $contact['email'] }}<br>
<br>
**メッセージ:**<br>
{!! nl2br(e($contact['message'])) !!}
</x-mail::panel>

@else
# お問い合わせありがとうございます

以下の内容でお問い合わせを受け付けました。<br>
担当者からの返信をお待ちください。

<x-mail::panel>
**お名前:** {{ $contact['name'] }}<br>
**メールアドレス:** {{ $contact['email'] }}<br>
<br>
**メッセージ:**<br>
{!! nl2br(e($contact['message'])) !!}
</x-mail::panel>

<x-mail::button :url="config('app.url')">
サイトに戻る
</x-mail::button>

今後ともよろしくお願いいたします。<br>
{{ config('app.name') }}
@endif
</x-mail::message>