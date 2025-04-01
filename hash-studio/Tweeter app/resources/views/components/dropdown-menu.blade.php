<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/Dropdown.css') }}">
    <title>Dropdown Menu</title>
</head>

<body>

    <div class="dropdown" style="display: {{ $tweet->user_id === auth()->id() ? 'inline' : 'none' }}">

        @if (!isset($menu))
            <div id="myDropdown{{ $tweet->id }}" class="dropdown-content" style="margin-left: 50px">
                @if (!isset($delete))
                    <form action="{{ route('tweets.destroy', $tweet->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none;margin-left: 430px">
                            <a href="#">
                                <img src="{{ asset('images/img/trash.png') }}" alt="Trash">
                            </a>
                        </button>
                    </form>
                @endif
                <div style="margin-left: 390px;margin-top: -22.7px">
                    <a href="{{ route('tweets.edit', $tweet->id) }}">
                        <img src="{{ asset('images/img/edit.png') }}" alt="Edit Tweet">
                    </a>
                </div>
            </div>
        @endif
    </div>
