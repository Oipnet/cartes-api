@extends('layout.base')

@section('content')
    <h1>@lang('config.notifications.title')</h1>
    <table>
        <thead>
            <tr>
                <th>@lang('config.notifications.id')</th>
                <th>@lang('config.notifications.channel')</th>
                <th>@lang('config.notifications.type')</th>
                <th>@lang('config.notifications.destination')</th>
                <th>@lang('config.notifications.active')</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($notifications as $notification)
            <tr>
                <td>{{ $notification->id_notification }}</td>
                <td>{{ $notification->channel }}</td>
                <td>{{ $notification->type }}</td>
                <td class="truncate" style="width: 150px">{{ $notification->destination }}</td>
                <td>{{ $notification->active }}</td>
                <td>
                    <a class="waves-effect waves-light btn" href="{{ route('notification_edit', ['id' => $notification->id_notification]) }}"><i class="material-icons">create</i></a>
                    <a class="waves-effect waves-light btn red delete-notification"
                       href="{{ route('notification_delete', ['id' => $notification->id_notification]) }}"
                    >
                        <i class="material-icons">delete</i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <form id="delete-form" style="display: none;" method="post">
        @method('DELETE')
        @csrf
    </form>
@endsection

@section('script')
    <script>

            const deleteLinks = document.querySelectorAll('.delete-notification')
            console.log(deleteLinks)
            deleteLinks.forEach((deleteLink) => {
                deleteLink.addEventListener('click', function(e) {
                    e.preventDefault()
                    const form = document.querySelector('#delete-form')
                    form.action = this.getAttribute('href')

                    form.submit()
                })
            })
    </script>
@endsection