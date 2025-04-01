@extends('layouts.app')
@section('content')

    <!-- Tweet -->
    <div
        class="border-b border-gray-200 dark:border-dim-200 hover:bg-gray-100 dark:hover:bg-dim-300 cursor-pointer transition duration-350 ease-in-out pb-4 border-l border-r">
        <div class="flex flex-shrink-0 p-4 pb-0">
            <a href="#" class="flex-shrink-0 group block">
                <div class="flex items-top">
                    <div>
                        <!-- Iterate over media if it's an array -->
                        @foreach ($tweet->user->media as $media)
                            <img class="inline-block h-9 w-9 rounded-full" src="{{ asset($media->media) }}"
                                alt="{{ $media->media }}" />
                        @endforeach
                    </div>


                    <div class="ml-3">
                        <p class="flex items-center text-base leading-6 font-medium text-gray-800 dark:text-white">
                            {{ $tweet->user->name }}
                            <svg viewBox="0 0 24 24" aria-label="Verified account" fill="currentColor"
                                class="w-4 h-4 ml-1 text-blue-500 dark:text-white">
                                <g>
                                    <path
                                        d="M22.5 12.5c0-1.58-.875-2.95-2.148-3.6.154-.435.238-.905.238-1.4 0-2.21-1.71-3.998-3.818-3.998-.47 0-.92.084-1.336.25C14.818 2.415 13.51 1.5 12 1.5s-2.816.917-3.437 2.25c-.415-.165-.866-.25-1.336-.25-2.11 0-3.818 1.79-3.818 4 0 .494.083.964.237 1.4-1.272.65-2.147 2.018-2.147 3.6 0 1.495.782 2.798 1.942 3.486-.02.17-.032.34-.032.514 0 2.21 1.708 4 3.818 4 .47 0 .92-.086 1.335-.25.62 1.334 1.926 2.25 3.437 2.25 1.512 0 2.818-.916 3.437-2.25.415.163.865.248 1.336.248 2.11 0 3.818-1.79 3.818-4 0-.174-.012-.344-.033-.513 1.158-.687 1.943-1.99 1.943-3.484zm-6.616-3.334l-4.334 6.5c-.145.217-.382.334-.625.334-.143 0-.288-.04-.416-.126l-.115-.094-2.415-2.415c-.293-.293-.293-.768 0-1.06s.768-.294 1.06 0l1.77 1.767 3.825-5.74c.23-.345.696-.436 1.04-.207.346.23.44.696.21 1.04z">
                                    </path>
                                </g>
                            </svg>
                            <span
                                class="ml-1 text-sm leading-5 font-medium text-gray-400 group-hover:text-gray-300 transition ease-in-out duration-150">
                                @ {{ $tweet->user->username }}
                                . {{ $tweet->creation_date_formatted }}

                            </span>

                            <!-- Dropdown Menu -->
                            @component('components.dropdown-menu', ['tweet' => $tweet, 'menu' => $pageTitle])
                            @endcomponent
                            <!-- / Dropdown Menu -->


                        </p>
                    </div>
                </div>
            </a>
        </div>
        <div class="pl-16">
            <form action="{{ route('tweets.update', $tweet->id) }}" method="POST">
                @csrf
                @method('PUT')
                <p class="text-base width-auto font-medium text-gray-800 dark:text-white flex-shrink">
                    <input
                        class="dark:text-white text-gray-900 placeholder-gray-400 w-full h-10 bg-transparent border-0 focus:outline-none resize-none"type="text"
                        name="description" value="{{ $tweet->description }}">
                    <br />

                    I will be a
                    <a href="#" class="text-blue-400 hover:underline">#President</a>
                    for all Americans — whether you voted for me or not.
                    <br />
                </p>

                <button style="background-color: none; border: none; margin-left: 210px" type="submit">
                    <a href="#" class="bg-blue-400 hover:bg-blue-500 text-white rounded-full py-1 px-4 ml-auto mr-1"
                        style="margin-left:220px ">
                        <span class="font-bold text-sm">Tweet</span>
                    </a>
                </button>

            </form>
            <!-- Iterate over media if it's an array -->
            <div class="flex my-3 mr-2 rounded-2xl border border-gray-600">
                @if (isset($tweet->media_one->media))
                    @if (Str::endsWith($tweet->media_one->media, ['.jpg', '.jpeg', '.png', '.gif']))
                        <!-- Display image -->
                        <img class="rounded-2xl" src="{{ asset($tweet->media_one->media) }}" alt="image media" />
                    @else
                        <!-- Display video -->
                        <video controls class="rounded-2xl">
                            <source src="{{ asset($tweet->media_one->media) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                @endif

                </a>

            </div>

            <div class="flex">
                <div class="w-full">
                    <div class="flex items-center">
                        <div
                            class="flex-1 flex items-center text-gray-800 dark:text-white text-xs text-gray-400 hover:text-blue-400 dark:hover:text-blue-400 transition duration-350 ease-in-out">
                            <form action="{{ route('fav-tweet.store', ['tweet_id' => $tweet->id]) }}" method="POST">
                                {{ csrf_field() }}

                                <button style="background: none; border: none" id = 'toggleButton'>

                                    <a href="#">
                                        <svg fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6"
                                            style="color: {{ $tweet->isFavoritedBy(auth()->user()) ? '#ff0000' : '#000000' }}">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19.9 23.5c-.157 0-.312-.05-.442-.144L12 17.928l-7.458 5.43c-.228.164-.53.19-.782.06-.25-.127-.41-.385-.41-.667V5.6c0-1.24 1.01-2.25 2.25-2.25h12.798c1.24 0 2.25 1.01 2.25 2.25v17.15c0 .282-.158.54-.41.668-.106.055-.223.082-.34.082zM12 16.25c.155 0 .31.048.44.144l6.71 4.883V5.6c0-.412-.337-.75-.75-.75H5.6c-.413 0-.75.338-.75.75v15.677l6.71-4.883c.13-.096.285-.144.44-.144z">
                                            </path>
                                        </svg>
                                    </a>
                                </button>


                            </form>
                            {{-- <x-select /> --}}
                            {{ $tweet->getFavoritesCount() }}

                        </div>
                        <!--- retweet --->
                        <div
                            class="flex-1 flex items-center text-gray-800 dark:text-white text-xs text-gray-400 hover:text-green-400 dark:hover:text-green-400 transition duration-350 ease-in-out">
                            <a href="{{ route('shareindex', $tweet->id) }}">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                                    <g>
                                        <path
                                            d="M23.77 15.67c-.292-.293-.767-.293-1.06 0l-2.22 2.22V7.65c0-2.068-1.683-3.75-3.75-3.75h-5.85c-.414 0-.75.336-.75.75s.336.75.75.75h5.85c1.24 0 2.25 1.01 2.25 2.25v10.24l-2.22-2.22c-.293-.293-.768-.293-1.06 0s-.294.768 0 1.06l3.5 3.5c.145.147.337.22.53.22s.383-.072.53-.22l3.5-3.5c.294-.292.294-.767 0-1.06zm-10.66 3.28H7.26c-1.24 0-2.25-1.01-2.25-2.25V6.46l2.22 2.22c.148.147.34.22.532.22s.384-.073.53-.22c.293-.293.293-.768 0-1.06l-3.5-3.5c-.293-.294-.768-.294-1.06 0l-3.5 3.5c-.294.292-.294.767 0 1.06s.767.293 1.06 0l2.22-2.22V16.7c0 2.068 1.683 3.75 3.75 3.75h5.85c.414 0 .75-.336.75-.75s-.337-.75-.75-.75z">
                                        </path>
                                    </g>
                                </svg>
                            </a>
                            {{ $tweet->getShareCount() }}
                        </div>
                        <!--- like --->
                        <div
                            class="flex-1 flex items-center text-gray-800 dark:text-white text-xs text-gray-400 hover:text-red-600 dark:hover:text-red-600 transition duration-350 ease-in-out">
                            <form action="{{ route('likes.store', ['tweet_id' => $tweet->id]) }}" method="POST">
                                {{ csrf_field() }}
                                <button style="background: none; border: none">
                                    <a href="#">

                                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2"
                                            style="color: {{ $tweet->isLikedBy(auth()->user()) ? '#ff0000' : '#000000' }}">
                                            >
                                            <g>
                                                <path
                                                    d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z">
                                                </path>
                                            </g>
                                        </svg>
                                    </a>
                                </button>
                            </form>
                            {{ $tweet->getLikesCount() }}
                        </div>
                        <div
                            class="flex-1 flex items-center text-gray-800 dark:text-white text-xs text-gray-400 hover:text-blue-400 dark:hover:text-blue-400 transition duration-350 ease-in-out">
                            <form action="{{ route('exploreindex', $tweet->id) }}" method="POST">
                                {{ csrf_field() }}
                                <button style="background: none; border: none">
                                    <a href="#">

                                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                                            <g>
                                                <path
                                                    d="M17.53 7.47l-5-5c-.293-.293-.768-.293-1.06 0l-5 5c-.294.293-.294.768 0 1.06s.767.294 1.06 0l3.72-3.72V15c0 .414.336.75.75.75s.75-.336.75-.75V4.81l3.72 3.72c.146.147.338.22.53.22s.384-.072.53-.22c.293-.293.293-.767 0-1.06z">
                                                </path>
                                                <path
                                                    d="M19.708 21.944H4.292C3.028 21.944 2 20.916 2 19.652V14c0-.414.336-.75.75-.75s.75.336.75.75v5.652c0 .437.355.792.792.792h15.416c.437 0 .792-.355.792-.792V14c0-.414.336-.75.75-.75s.75.336.75.75v5.652c0 1.264-1.028 2.292-2.292 2.292z">
                                                </path>
                                            </g>
                                        </svg>
                                    </a>
                                </button>
                            </form>

                            {{ $tweet->explore !== null && $tweet->explore != 0 ? $tweet->explore : 0 }}
                        </div>
                        <!--- report --->
                        <div
                            class="flex-1 flex items-center text-gray-800 dark:text-white text-xs text-gray-400 hover:text-blue-400 dark:hover:text-blue-400 transition duration-350 ease-in-out">
                            <form action="{{ route('reportindex', $tweet->id) }}" method="POST">
                                {{ csrf_field() }}
                                <button style="background: none; border: none">
                                    <a href="#">

                                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                                            <g>
                                                <!-- Flagpole -->
                                                <path d="M4 2h2v20H4z"></path>
                                                <!-- Flag -->
                                                <path d="M6 2h12l-2 6 2 6H6z"></path>
                                            </g>
                                        </svg>

                                    </a>
                                </button>
                            </form>

                            {{ $tweet->report !== null && $tweet->report != 0 ? $tweet->report : 0 }}
                        </div>
                        <div
                            class="flex-1 flex items-center text-gray-800 dark:text-white text-xs text-gray-400 hover:text-blue-400 dark:hover:text-blue-400 transition duration-350 ease-in-out">
                            <img src="{{ Url('images/img/eye.png') }}" alt="eye" class="w-5 h-5 mr-2">
                            {{ $tweet->view !== null && $tweet->view != 0 ? $tweet->view : 0 }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
