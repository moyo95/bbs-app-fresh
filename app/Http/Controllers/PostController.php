<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth; // これは既に追加済みのはず

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::query();

        // 検索処理 (これは変更なし)
        if ($request->has('search') && $request->filled('search')) {
            $searchType = $request->input('search_type');
            $searchKeyword = $request->input('search');

            switch ($searchType) {
                case 'prefix':
                    $query->where('title', 'LIKE', $searchKeyword . '%');
                    break;
                case 'suffix':
                    $query->where('title', 'LIKE', '%' . $searchKeyword);
                    break;
                case 'partial':
                    $query->where('title', 'LIKE', "%{$searchKeyword}%");
                    break;
                default:
                    $query->where('title', 'LIKE', "%{$searchKeyword}%");
                    break;
            }
        }

        // ▼▼▼ ここからが修正箇所 ▼▼▼

        // ソート処理
        $sortType = $request->input('sort', 'newest');
        
        // 既存のORDER BY句をリセット
        $query->reorder();

        switch ($sortType) {
            case 'oldest':
                $query->oldest(); // orderBy('created_at', 'asc') の代わり
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'newest':
            default: // defaultをnewestのケースにまとめる
                $query->latest(); // orderBy('created_at', 'desc') の代わり
                break;
        }
        
        // ▲▲▲ ここまでが修正箇所 ▲▲▲

        $posts = $query->paginate(5);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ▼▼▼ この部分だけをコピーする ▼▼▼
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('posts.show', ['post' => $post->id])->with('success', '掲示板の投稿に成功しました');
    }

    /**
     * Display the specified resource.
     */
    // app/Http/Controllers/PostController.php の中
    public function show(Post $post)
    {
        $post->load('comments.user', 'likes.user');

        $isLiked = false;
        if(auth()->check()) {
            $isLiked = $post->isLikedBy(auth()->user());
        }

        // 3. ボタンのスタイルを配列で定義
        $likedClasses = ['bg-red-500', 'text-white'];
        $unlikedClasses = ['text-gray-500', 'border', 'border-gray-300', 'hover:bg-red-50', 'hover:text-red-500'];
        
        // 4. コメントを取得
        // $comments = $post->comments;
        $comments = $post->comments()->latest()->paginate(5);

        // ★★★ 必要な変数を全てビューに渡します ★★★
        return view('posts.show', compact(
            'post',
            'comments',
            'isLiked',
            'likedClasses',
            'unlikedClasses'
        ));

        // // ▼▼▼ 元のコードに戻す ▼▼▼
        // $post->load('comments.user', 'likes', 'user');
        // $comments = $post->comments()->with('user')->paginate(1);
        //     return view('posts.show', compact(
        //     'post', 
        //     'comments', 
        //     'isLiked', 
        //     'likedClasses', 
        //     'unlikedClasses'
        // ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        // ▼▼▼ 元のコードに戻す ▼▼▼
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // ▼▼▼ この中身に置き換える ▼▼▼
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'この投稿を編集する権限がありません。');
        }
        
        $post->update([
            'title' =>  $request->title,
            'content' =>  $request->content
        ]);

        return redirect()->route('posts.show', $post->id)->with('success', '投稿を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // ▼▼▼ この中身に置き換える ▼▼▼
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index')->with('error', 'この投稿を削除する権限がありません。');
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', '投稿を削除しました。');
    }
}
