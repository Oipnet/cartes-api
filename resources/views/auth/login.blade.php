@extends('layout.base')

@section('content')
<div class="container">
    <div class="row">
        <div class="s8">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">{{ __('Login') }}</span>
                    <div class="row">
                        <form class="col s12" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="{{ __('E-Mail Address') }}" id="email" type="email" class="validate" name="email" value="{{ old('email') }}" required autofocus>
                                    <label for="email">{{ __('E-Mail Address') }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input placeholder="{{ __('Password') }}" id="password" type="password" class="validate" name="password" required>
                                    <label for="password">{{ __('Password') }}</label>
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn waves-effect waves-light col s12" type="submit" name="action">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
