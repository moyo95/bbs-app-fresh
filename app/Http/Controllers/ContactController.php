<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail; // クラス名を修正


class ContactController extends Controller
{
    //お問合せフォーム
    public function index()
    {
        return view('contact.index');
    }

    //確認画面の表示
    public function confirm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        //確認画面の表示
        $contactData = $request->all();
        return view('contact.confirm', compact('contactData'));

    }

    //お問合せ内容の送信処理
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        $contactData = $request->only('name', 'email', 'message');

        //メールの送信（運営者）
        // Mail::to(config('mail.from.address'))->send(new ContactMail($contactData, 'admin'));
        Mail::to(config('mail.from.address'))->send(new ContactMail($contactData, 'admin')); // Maill -> Mail

        //メール送信（ユーザー）
        Mail::to($request->email)->send(new ContactMail($contactData, 'user'));

        //フラッシュメッセージに保存
        session()->flash('success', 'お問合せが送信されました。');
        

        return redirect()->route('contact.complete');
    }

    //お問合せ完了
    public function complete()
    {
        return view('contact.complete');
    }
}
