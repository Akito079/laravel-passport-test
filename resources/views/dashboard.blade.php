<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("create_clients") }}
                </div>
                <form action="{{route('passport.clients.store')}}">
                @csrf
                    <div class="my-2">
                        <label for="name">Name</label>
                        <input class="block rounded-lg border-2 bordergray-300" type="text" name="name" id=""placeholder="Enter Name">
                    </div>
                    <div class="my-2">
                        <label for="redirect">Redirect</label>
                        <input class="block rounded-lg border-2 bordergray-300" type="text" name="redirect" id=""placeholder="Enter Redirect">
                    </div>
                    <div class="my-2">
                        <button type="submit" class="px-4 py-2 bg-black rounded-lg text-white">Create CLients</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
