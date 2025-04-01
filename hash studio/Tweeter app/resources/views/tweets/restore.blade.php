@extends('layouts.app')
@section('content')
    <!-- Tweet -->
    @foreach ($tweets as $tweet)
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

                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="pl-16">
                <p class="text-base width-auto font-medium text-gray-800 dark:text-white flex-shrink">
                    {{ $tweet->description }}
                    <br />
                    I
                    will be a
                    <a href="#" class="text-blue-400 hover:underline">#President</a>
                    for all Americans — whether you voted for me or not.<br />
                    <br />
                </p>
                <!-- Iterate over media if it's an array -->
                <div class="flex my-3 mr-2 rounded-2xl border border-gray-600">
                    @if (isset($tweet->media))
                        @foreach ($tweet->media as $media)
                            <a href="{{ route('tweets.show', $tweet->id) }}">
                                @if (Str::endsWith($media->media, ['.jpg', '.jpeg', '.png', '.gif']))
                                    <!-- Display image -->
                                    <img class="rounded-2xl" src="{{ asset($media->media) }}" alt="image media" />
                                @else
                                    <!-- Display video -->
                                    <video controls class="rounded-2xl">
                                        <source src="{{ asset($media->media) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                            </a>
                        @endforeach
                    @endif

                </div>

                <div class="flex">
                    <div class="w-full">
                        <div class="flex items-center">
                            <div
                                class="flex-1 flex items-center text-gray-800 dark:text-white text-xs text-gray-400 hover:text-blue-400 dark:hover:text-blue-400 transition duration-350 ease-in-out">
                            </div>
                            <div style="margin-right: 120px"
                                class="flex-1 flex items-center text-gray-800 dark:text-white text-xs text-gray-400 hover:text-blue-400 dark:hover:text-blue-400 transition duration-350 ease-in-out">
                                <img src="{{ Url('images/img/eye.png') }}" alt="eye" class="w-5 h-5 mr-2">
                                {{ $tweet->view !== null && $tweet->view != 0 ? $tweet->view : 0 }}

                            </div>

                            <div style="margin-right: 100px"
                                class="flex-1 flex items-center text-gray-800 dark:text-white text-xs text-gray-400 hover:text-red-600 dark:hover:text-red-600 transition duration-350 ease-in-out">

                                <a href="{{ route('destroy-Force', ['tweet' => $tweet->id]) }}">
                                    <img src="{{ asset('images/img/trash.png') }}" alt="trash">
                                </a>

                            </div>
                            <div style="margin-right: 50px"
                                class="flex-1 flex items-center text-gray-800 dark:text-white text-xs text-gray-400 hover:text-blue-400 dark:hover:text-blue-400 transition duration-350 ease-in-out">
                                <a href="{{ route('restore', ['tweet' => $tweet->id]) }}">

                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2">
                                        <g>
                                            <!-- Upward arrow -->
                                            <path
                                                d="M17.53 7.47l-5-5c-.293-.293-.768-.293-1.06 0l-5 5c-.294.293-.294.768 0 1.06s.767.294 1.06 0l3.72-3.72V15c0 .414.336.75.75.75s.75-.336.75-.75V4.81l3.72 3.72c.146.147.338.22.53.22s.384-.072.53-.22c.293-.293.293-.767 0-1.06z">
                                            </path>
                                            <!-- Base -->
                                            <path
                                                d="M19.708 21.944H4.292C3.028 21.944 2 20.916 2 19.652V14c0-.414.336-.75.75-.75s.75.336.75.75v5.652c0 .437.355.792.792.792h15.416c.437 0 .792-.355.792-.792V14c0-.414.336-.75.75-.75s.75.336.75.75v5.652c0 1.264-1.028 2.292-2.292 2.292z">
                                            </path>
                                        </g>
                                    </svg>

                                </a>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /Tweet -->
    @endforeach
@endsection
