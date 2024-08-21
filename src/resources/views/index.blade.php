@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

@if (session('success'))
<div class="todo__alert">
    <div class="todo__alert--success">
        {{ session('success') }}
    </div>
</div>
@endif
@if ($errors->any())
<div class="todo__alert--error">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="todo__content">
    <div class="section__title">
        <h2>新規作成</h2>
    </div>
    <form action="/todos" class="create-form" method="post">
        @csrf
        <div class="create-form__item">
            <input type="text" class="create-form__item-input" name="content" value="{{ old('content') }}">
            <select class="create-form__item-select" name="category_id">
                <option value="">カテゴリ</option>
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
            <div class="create-form__button">
                <button class="create-form__button-submit">作成</button>
            </div>
        </div>
    </form>
    <div class="section__title">
        <h2 class="todo__content-title">Todo検索</h2>
    </div>
    <form action="/todos/search" class="search-form" method="get">
        @csrf
        <div class="search-form__item">
            <input type="text" class="search-form__item-input" name="keyword" value="{{ old('keyword') }}">
            <select name="category_id" class="search-form__item-select">
                <option value="">カテゴリ</option>
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>
            <div class="search-form__button">
                <button class="search-form__button-submit">検索</button>
            </div>
        </div>
    </form>
    <div class="list-table">
        <table class="list-table__inner">
            <tr class="list-table__row">
                <th class="list-table__header">
                    <span class="list-table__header-span">Todo</span>
                    <span class="list-table__header-span">カテゴリ</span>
                </th>
            </tr>
            @foreach ($todos as $todo)
            <tr class="list-table__row">
                <td class="list-table__item">
                    <form action="/todos/update" class="update-form" method="post">
                        @method('PATCH')
                        @csrf
                        <div class="update-form__item">
                            <input type="text" class="update-form__item-input" name="content" value="{{ $todo['content'] }}">
                            <input type="hidden" name="id" value="{{ $todo['id'] }}">
                        </div>
                        <div class="update-form__item">
                            <p class="update-form__item-p">{{ $todo['category']['name'] }}</p>
                        </div>
                        <div class="update-form__button">
                            <button class="update-form__button-submit">更新</button>
                        </div>
                    </form>
                </td>
                <td class="list-table__item">
                    <form action="/todos/delete" class="delete-form" method="post">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="id" value="{{ $todo['id'] }}">
                        <div class="delete-form__button">
                            <button class="delete-form__button-submit">削除</button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection