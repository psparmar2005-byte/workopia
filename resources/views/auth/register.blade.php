<x-layout>
    <x-slot name="title">Register</x-slot>
    <div class="bg-white rounded-lg shadow-md w-full md:max-w-xl  mx-auto mt-12 p-8 py-12">
        <h2 class="text-4xl text-center font-bold mb-4">Register</h2>
        <form method="POST" action="{{ route('register.store') }}">
            @csrf
            <x-inputs.text name="name" id="name" placeholder="Enter Name" />
            <x-inputs.text name="email" id="email" placeholder="Enter Email" />
            <x-inputs.text name="password" id="password" type="password" placeholder="Enter Password" />
            <x-inputs.text name="password_confirmation" id="password_confirmation" type="password"
                placeholder="Confirm Password" />
            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Submit</button>
            <p class="mt-3"> Already have an account?
                <a href="{{ route('login') }}" class="text-blue-900 hover:underline">Login</a>
            </p>
        </form>
    </div>
</x-layout>
