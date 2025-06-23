<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    // ★★★ このメソッドを追加 ★★★
    public function check()
    {
        return '成功！テストコントローラーは動作しています！';
    }
}