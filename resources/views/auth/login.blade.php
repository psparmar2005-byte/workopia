<x-layout>
    <x-slot name="title">Login</x-slot>
    <div class="bg-white rounded-lg shadow-md w-full md:max-w-xl  mx-auto mt-12 p-8 py-12">
        <h2 class="text-4xl text-center font-bold mb-4">Login</h2>
        <form method="POST" action="{{ route('login.authenticate') }}">
            @csrf
            <x-inputs.text name="email" id="email" placeholder="Enter Email" />
            <x-inputs.text name="password" id="password" type="password" placeholder="Enter Password" />
            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Login</button>
            <p class="mt-3"> Don't have an account?
                <a href="{{ route('register') }}" class="text-blue-900 hover:underline">Register</a>
            </p>
        </form>
    </div>
</x-layout>
