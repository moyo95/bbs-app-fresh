<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * お問い合わせデータ
     * publicにすることで、ビューで自動的に使えるようになります
     * @var array
     */
    public array $contact;

    /**
     * メールの役割 ('admin' または 'user')
     * publicにすることで、ビューで自動的に使えるようになります
     * @var string
     */
    public string $role;

    /**
     * 新しいメッセージインスタンスを作成します。
     *
     * @param array $contactData  コントローラーから渡されるお問い合わせデータ
     * @param string $role         コントローラーから渡される役割 ('admin' or 'user')
     * @return void
     */
    public function __construct(array $contactData, string $role)
    {
        // 受け取ったデータを、このクラスのプロパティに保存します
        $this->contact = $contactData;
        $this->role = $role;
    }

    /**
     * メールのエンベロープ（件名など）を取得します。
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope(): Envelope
    {
        // 役割に応じて件名を動的に変更します
        $subject = ($this->role === 'admin') 
                    ? '【サイトから】新しいお問い合わせがありました' 
                    : '【自動返信】お問い合わせありがとうございます';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * メールのコンテンツ定義を取得します。
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        // ここでメールの見た目を定義するビューファイルを指定します
        return new Content(
            markdown: 'emails.contact',
        );
    }

    /**
     * メールの添付ファイルを取得します。
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}