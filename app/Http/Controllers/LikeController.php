<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//LikeController.php
class LikeController extends Controller
{
    public function toggleLike(Post $post, Request $request)
    {
        $user = Auth::user();

        // ユーザーがいいねしているかチェック
        $like = $post->likes()->where('user_id', $user->id)->first();

        if ($like) {
            // いいねが存在すれば、削除（いいねを取り消し）
            $like->delete();
            $isLiked = false;
        } else {
            // いいねが存在しなければ、作成（いいねする）
            $post->likes()->create([
                'user_id' => $user->id
            ]);
            $isLiked = true;
        }

        // ★★★ ここが最も重要です ★★★
        // 現在のいいねの総数と、処理後のいいねの状態をJSONで返す
        return response()->json([
            'isLiked' => $isLiked,
            'likeCount' => $post->likes()->count()
        ]);
    }
}