<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::query();

        //絞り込み検索
        if ($request->has('search') && $request->filled('search')) {
            $searchType = $request->input('search_type');
            $searchKeyword = $request->input('search');

            switch($searchType){
                case 'prefix':
                    $query->where('title', 'LIKE', $searchKeyword .'%');
                    break;
                case 'suffix':
                    $query->where('title', 'LIKE',  '%' .$searchKeyword);
                    break;
                case 'partial':
                    $query->where('title', 'LIKE', "%{$searchKeyword}%");
                    break;
                default:
                    $query->where('title', 'LIKE', "%{$searchKeyword}%");
                    break;
            }
        }

        //ソート処理
        $sortType = $request->input('sort', 'newest');
        
        switch($sortType){
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $posts = $query->paginate(5);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::check()) {
            return redirect()->route('login');
        }
        
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);

        // dd($request->all());//デバッグ用
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id()
        ]);
        // return redirect()->route('posts.index');
        return redirect()->route('posts.show', ['post' => $post->id])->with('success', '掲示板の投稿に成功しました');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('comments.user', 'likes', 'user')->findOrFail($id);
        $comments = $post->comments()->with('user')->paginate(1);
        // dd($post);
        return view('posts.show', compact('post', 'comments'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        // dd($post);

        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index');
        }
        
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required'
        ]);
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index');
        }
        

        $post->update([
            'title' =>  $request->title,
            'content' =>  $request->content
        ]);
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if (Auth::id() !== $post->user_id) {
            return redirect()->route('posts.index');
        }

        $post->delete();
        return redirect()->route('posts.index');
    }
}
