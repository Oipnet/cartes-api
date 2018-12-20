@extends('layout.base')

@section('content')
    <h1 class="card-title truncate">{{ $item->title }}</h1>

    <div class="row">
        <form action="{{ route('item_update', ['id' => $item->id_item]) }}" method="POST" class="col s12">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="title" class="materialize-textarea" name="title" required autofocus>{{ old('title') ?? $item->title }}</textarea>
                    <label for="title">@lang('item.title')</label>
                </div>
                <div class="input-field col s12">
                    <textarea id="description" class="materialize-textarea" name="description" required autofocus>{{ old('description') ?? $item->description }}</textarea>
                    <label for="description">@lang('item.description')</label>
                </div>
                <div class="input-field col s12">
                    <input placeholder="@lang('item.price')" id="price_starting" type="number" class="validate" name="price_starting" value="{{ old('price_starting') ?? $item->price_starting }}" required>
                    <label for="price_starting">@lang('item.price')</label>
                </div>
            </div>
            <div class="row">
                <button class="btn waves-effect waves-light col s12" type="submit" name="action">
                    @lang('submit')
                </button>
            </div>
        </form>
    </div>
@endsection