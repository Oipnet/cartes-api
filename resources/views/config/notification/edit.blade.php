@extends('layout.base')

@section('content')
    <div class="card">
        <div class="card-content">
            <h1 class="card-title">@lang('config.notifications.title')</h1>

            <div class="row">
                <form action="{{ route('notification_update', ['id' => $notification->id_notification]) }}" method="POST" class="col s12">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="input-field col s12">
                            <input placeholder="@lang('config.notifications.destination')" id="destination" type="text" class="validate" name="destination" value="{{ old('destination') ?? $notification->destination }}" required autofocus>
                            <label for="destination">@lang('config.notifications.destination')</label>
                        </div>
                    </div>
                    <div class="row">
                        <button class="btn waves-effect waves-light col s12" type="submit" name="action">
                            @lang('submit')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection