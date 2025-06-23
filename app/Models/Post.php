<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // HasFactoryを追加すると便利です
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // 型付けを追加
use Illuminate\Database\Eloquent\Relations\HasMany;   // 型付けを追加

class Post extends Model
{
    // ★ HasFactory を追加
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];

    /**
     * この投稿に紐づくコメントを取得します。
     */
    public function comments(): HasMany // ★戻り値の型を追加
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * この投稿に紐づく「いいね」を取得します。
     */
    public function likes(): HasMany // ★戻り値の型を追加
    {
        return $this->hasMany(Like::class);
    }

    /**
     * この投稿を所有するユーザーを取得します。
     */
    public function user(): BelongsTo // ★戻り値の型を追加
    {
        return $this->belongsTo(User::class);
    }


    // ▼▼▼▼▼ このメソッドを新しく追加しました ▼▼▼▼▼

    /**
     * 指定されたユーザーによって、この投稿がいいねされているかを確認します。
     *
     * @param  \App\Models\User|null  $user
     * @return bool
     */
    public function isLikedBy(?User $user): bool
    {
        // ユーザーが null (ログインしていないなど) の場合は、いいねされていない
        if (is_null($user)) {
            return false;
        }

        // この投稿の「いいね」の中に、指定されたユーザーのIDが存在するかどうかをチェックします
        // exists() を使うことで、効率的に存在確認ができます
        // return $this->likes()->where('user_id', $user->id)->exists();
        return $this->likes->contains('user_id', $user->id);
    }
}