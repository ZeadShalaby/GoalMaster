@extends('layouts.app')
@section('content')
    <br />
    <div>
        <form action="{{ route('user.update', $users->id) }}" method="POST" style="margin: 10px; padding: 10px">
            @csrf
            @method('PUT')
            <input type="text" style="border-radius: 10px;border: 1px solid rgb(31, 97, 160);"
                class="dark:text-white text-gray-900 placeholder-gray-400 w-full h-10 bg-transparent focus:outline-none resize-none"
                value="{{ $users->name }}" name="name" autocomplete="name" required>
            <br><br>
            <input type="email" style="border-radius: 10px;border: 1px solid rgb(31, 97, 160);"
                class="dark:text-white text-gray-900 placeholder-gray-400 w-full h-10 bg-transparent focus:outline-none resize-none"
                value="{{ $users->email }}" name="email" autocomplete="email" required>
            <br> <br>
            <input type="password" style="border-radius: 10px;border: 1px solid rgb(31, 97, 160);"
                class="dark:text-white text-gray-900 placeholder-gray-400 w-full h-10 bg-transparent focus:outline-none resize-none"
                value="{{ $users->password }}" name="password" autocomplete="password" required>
            <br><br>
            <input type="date" style="border-radius: 10px;border: 1px solid rgb(31, 97, 160);"
                class="dark:text-white text-gray-900 placeholder-gray-400 w-full h-10 bg-transparent focus:outline-none resize-none"
                value="{{ $users->birthday }}" name="birthday">
            <br><br>
            <span style="color: rgb(31, 97, 160)">{{ $users->gender }}</span>
            <br><br>

            <button style="background-color: none; border: none" type="submit">
                <a href="#" class="bg-blue-400 hover:bg-blue-500 text-white rounded-full py-1 px-4 ml-auto mr-1"
                    style="margin-left:255px ">
                    <span class="font-bold text-sm">Save</span>
                </a>
            </button>
        </form>
    </div>
@endsection
