<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Category;
use Illuminate\Http\Request;
// フォームリクエストの読み込み
use App\Http\Requests\TodoRequest;

class TodoController extends Controller
{
    public function index()
    {
        // todo情報取得
        $todos = Todo::with('category')->get();
        // カテゴリ情報取得
        $categories = Category::all();

        return view('index', compact('todos', 'categories'));
    }

    public function store(TodoRequest $request)
    {
        $form = $request->only(['content', 'category_id']);
        Todo::create($form);
        return redirect('/')->with('success', 'Todoを作成しました');
    }

    public function update(TodoRequest $request)
    {
        $form = $request->only('content');
        Todo::find($request->id)->update($form);
        return redirect('/')->with('success', 'Todoを更新しました');
    }

    public function destroy(Request $request)
    {
        Todo::find($request->id)->delete();
        return redirect('/')->with('success', 'Todoを削除しました');
    }

    public function search(Request $request)
    {
        $todos = Todo::with('category')->CategorySearch($request->category_id)->KeywordSearch($request->keyword)->get();
        $categories = Category::all();

        return view('index', compact('todos', 'categories'));
    }
}
