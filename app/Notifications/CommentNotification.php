<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;

class CommentNotification extends Notification
{
    use Queueable;

    protected $post; // プロパティを追加

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post) // ← Post $post を引数として追加
    {
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('あなたの投稿に新しいコメントがつきました！')
                    ->line('あなたの投稿「' . $this->post->title . '」に新しいコメントがあります。')
                    ->action('投稿を見に行く', url('/posts/' . $this->post->id))
                    ->line('ご利用いただき、ありがとうございます！');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
