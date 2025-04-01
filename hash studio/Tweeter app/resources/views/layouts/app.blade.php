<!DOCTYPE html>
<html class="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="./style.css" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ URL('images/img/twitter-logo.png') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/tweet.css') }}">

</head>


<body class="bg-white dark:bg-dim-900">

    <!--  Warn alert -->
    @if (Session::has('warn'))
        <div class="alert-warning">
            {{ Session::get('warn') }}
        </div>
        </div>
    @endif
    <!-- success alert -->
    @if (Session::has('success'))
        <div class="alert-success">
            {{ Session::get('success') }}
        </div>
        </div>
    @endif
    <!-- error alert -->
    @if (Session::has('error'))
        <div class="alert-error">
            {{ Session::get('error') }}
        </div>
        </div>
    @endif

    <!-- delete alert -->
    @if (Session::has('delete'))
        <div class="alert-delete">
            {{ Session::get('delete') }}
        </div>
        </div>
    @endif

    <!-- explore alert -->
    @if (Session::has('explore'))
        <div class="alert-explore">
            {{ Session::get('explore') }}
        </div>
        </div>
    @endif



    <div class="container mx-auto h-screen">
        <div class="flex flex-row justify-center">
            <!-- Left -->
            <div class="w-68 xs:w-88 xl:w-275 h-screen">
                <div class="flex flex-col h-screen xl:pr-3 fixed overflow-y-auto w-68 xs:w-88 xl:w-275">
                    <!-- nav -->
                    <x-route-left />
                    <!-- end nav -->
                </div>
            </div>
            <!-- /Left -->

            <!-- Middle -->
            <div class="w-full sm:w-600 h-screen">
                <div
                    class="flex justify-between items-center border-b px-4 py-3 sticky top-0 bg-white dark:bg-dim-900 border-l border-r border-gray-200 dark:border-gray-700">
                    <!-- Title -->
                    <h2 class="text-gray-800 dark:text-gray-100 font-bold font-sm">
                        {{ $pageTitle }}
                    </h2>
                    <!-- /Title -->

                    <!-- Custom Timeline -->
                    <div>
                        <form action="{{ route('users.image') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <a
                                href="#"class="text-blue-400 hover:bg-blue-50 dark:hover:bg-dim-800 rounded-full p-2">

                                <label for="file-upload"
                                    style="cursor: pointer; display: inline-block; border: none; background: none;">
                                    <input id="file-upload" class="form-control-file" type="file" accept="image/*"
                                        name="media" style="display: none;">


                                    <svg viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor">
                                        <g>
                                            <path
                                                d="M19.75 2H4.25C3.01 2 2 3.01 2 4.25v15.5C2 20.99 3.01 22 4.25 22h15.5c1.24 0 2.25-1.01 2.25-2.25V4.25C22 3.01 20.99 2 19.75 2zM4.25 3.5h15.5c.413 0 .75.337.75.75v9.676l-3.858-3.858c-.14-.14-.33-.22-.53-.22h-.003c-.2 0-.393.08-.532.224l-4.317 4.384-1.813-1.806c-.14-.14-.33-.22-.53-.22-.193-.03-.395.08-.535.227L3.5 17.642V4.25c0-.413.337-.75.75-.75zm-.744 16.28l5.418-5.534 6.282 6.254H4.25c-.402 0-.727-.322-.744-.72zm16.244.72h-2.42l-5.007-4.987 3.792-3.85 4.385 4.384v3.703c0 .413-.337.75-.75.75z">
                                            </path>
                                            <circle cx="8.868" cy="8.309" r="1.542"></circle>
                                        </g>
                                    </svg>
                                </label>
                            </a>

                            <button><svg viewBox="0 0 24 24" class="w-5 h-5 text-blue-400" fill="currentColor">
                                    <g>
                                        <path
                                            d="M22.772 10.506l-5.618-2.192-2.16-6.5c-.102-.307-.39-.514-.712-.514s-.61.207-.712.513l-2.16 6.5-5.62 2.192c-.287.112-.477.39-.477.7s.19.585.478.698l5.62 2.192 2.16 6.5c.102.306.39.513.712.513s.61-.207.712-.513l2.16-6.5 5.62-2.192c.287-.112.477-.39.477-.7s-.19-.585-.478-.697zm-6.49 2.32c-.208.08-.37.25-.44.46l-1.56 4.695-1.56-4.693c-.07-.21-.23-.38-.438-.462l-4.155-1.62 4.154-1.622c.208-.08.37-.25.44-.462l1.56-4.693 1.56 4.694c.07.212.23.382.438.463l4.155 1.62-4.155 1.622zM6.663 3.812h-1.88V2.05c0-.414-.337-.75-.75-.75s-.75.336-.75.75v1.762H1.5c-.414 0-.75.336-.75.75s.336.75.75.75h1.782v1.762c0 .414.336.75.75.75s.75-.336.75-.75V5.312h1.88c.415 0 .75-.336.75-.75s-.335-.75-.75-.75zm2.535 15.622h-1.1v-1.016c0-.414-.335-.75-.75-.75s-.75.336-.75.75v1.016H5.57c-.414 0-.75.336-.75.75s.336.75.75.75H6.6v1.016c0 .414.335.75.75.75s.75-.336.75-.75v-1.016h1.098c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z">
                                        </path>
                                    </g>
                                </svg></button>
                        </form>

                    </div>
                    <!-- /Custom Timeline -->
                </div>
                @yield('content')

                <x-timeline-spanner />

            </div>


            <!-- right --->
            <div class="hidden md:block w-290 lg:w-350 h-screen">
                <!-- What’s happening #exolore -->

                @component('components.trending', ['trending' => $trending])
                @endcomponent

                <!-- /What’s happening #exolore -->
                <!-- Who to follow -->
                <div class="bg-gray-50 dark:bg-dim-700 rounded-2xl m-2">
                    <h1
                        class="text-gray-900 dark:text-white text-md font-bold p-3 border-b border-gray-200 dark:border-dim-200">
                        Who to follow
                    </h1>
                    <!-- Who to follow -->
                    @component('components.follow', ['follow' => $follow])
                    @endcomponent
                    <!-- /Who to follow -->
                </div>
                <footer>
                    <ul class="text-xs text-gray-500 my-4 mx-2">
                        <li class="inline-block mx-2">
                            <a class="hover:underline" href="#">Terms of Service</a>
                        </li>
                        <li class="inline-block mx-2">
                            <a class="hover:underline" href="#">Privacy Policy</a>
                        </li>
                        <li class="inline-block mx-2">
                            <a class="hover:underline" href="#">Cookie Policy</a>
                        </li>
                        <li class="inline-block mx-2">
                            <a class="hover:underline" href="#">Ads info</a>
                        </li>
                        <li class="inline-block mx-2">
                            <a class="hover:underline" href="#">More</a>
                        </li>
                        <li class="inline-block mx-2">© 2020 Twitter, Inc.</li>
                    </ul>
                </footer>
            </div>
        </div>
    </div>


</body>
