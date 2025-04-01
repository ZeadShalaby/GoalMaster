@extends('layouts.app')
@section('content')
    <!-- Who to follow -->
    <div class="bg-gray-50 dark:bg-dim-700 rounded-2xl m-2">
        <h1 class="text-gray-900 dark:text-white text-md font-bold p-3 border-b border-gray-200 dark:border-dim-200">
            {{ $pageTitle }}
        </h1>
        <!-- Who to follow -->
        @if ($pageTitle == 'Followers')
            @component('components.followers', ['follow' => $follows, 'pageTitle' => $pageTitle])
            @endcomponent
        @else
            @component('components.following', ['follow' => $follows, 'pageTitle' => $pageTitle])
            @endcomponent
        @endif

        <!-- /Who to follow -->
    </div>
@endsection
