@extends('layout.base')

@section('content')
    <h1 class="center-align">@lang('homepage.dashboard')</h1>
    <div class="row">
        <div class="col s12 m4">
            <div class="card hoverable">
                <div class="card-content">
                    <h2 class="card-title right-align">@lang('item.count')</h2>
                    <div class="right-align" style="font-size: x-large">{{ $countItems }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection