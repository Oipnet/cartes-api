@extends('layout.base')

@section('content')
    <h1>@lang('item.list.title')</h1>
    <table>
        <thead>
        <tr>
            <th>@lang('item.id')</th>
            <th>@lang('item.title')</th>
            <th>@lang('item.description')</th>
            <th>@lang('item.price')</th>
            <th>@lang('item.date_end')</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->personal_reference }}</td>
                <td style="width: 200px">{{ $item->title }}</td>
                <td style="width: 150px" class="truncate">{{ $item->description }}</td>
                <td>{{ $item->price_starting }}</td>
                <td>{{ $item->date_end->format('d-m-Y') }}</td>
                <td>
                    <a class="waves-effect waves-light btn" href="{{ route('item_edit', ['id' => $item->id_item]) }}"><i class="material-icons">create</i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection