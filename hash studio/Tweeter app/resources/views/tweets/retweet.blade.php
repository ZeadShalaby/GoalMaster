@extends('layouts.app')
@section('content')

    <!-- New Tweets -->
    <div class="border-b border-gray-200 dark:border-dim-200 bg-gray-50 dark:bg-dim-300 py-2 border-l border-r">
        <form action="{{ route('share.store', $tweet->id) }}" method="POST">
            {{ csrf_field() }}
            <div
                class="flex flex-shrink-0 items-center justify-center py-4 bg-white dark:bg-dim-900 border-b border-t border-gray-200 dark:border-dim-200 hover:bg-gray-50 dark:hover:bg-dim-300 cursor-pointer transition duration-350 ease-in-out text-blue-400 text-sm">
                <textarea
                    class="dark:text-white text-gray-900 placeholder-gray-400 w-full h-10 bg-transparent border-0 focus:outline-none resize-none"
                    placeholder="What's happening?" name="description"></textarea>
            </div>
            <button style="background-color: none; border: none; margin-left: 250px;margin-top:8px" type="submit">
                <a href="#" class="bg-blue-400 hover:bg-blue-500 text-white rounded-full py-1 px-4 ml-auto mr-1"
                    style="margin-left:220px ">
                    <span class="font-bold text-sm">Tweet</span>
                </a>
            </button>
        </form>
    </div>
    <!-- /New Tweets -->
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
                            @component('components.dropdown-menu', ['tweet' => $tweet, 'pageTitle' => $pageTitle])
                            @endcomponent
                            <!-- / Dropdown Menu -->


                        </p>
                    </div>
                </div>
            </a>
        </div>
        <div class="pl-16">

            <p class="text-base width-auto font-medium text-gray-800 dark:text-white flex-shrink">
                {{ $tweet->description }}
                <br />
                < I will be a <a href="#" class="text-blue-400 hover:underline">#President</a>
                    for all Americans — whether you voted for me or not.<br />
                    <br />
            </p>

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


        </div>
    </div>


@endsection
