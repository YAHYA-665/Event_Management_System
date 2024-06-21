<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('New Event') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('events.update', $event) }}" x-data="{
                country: null,
                cityId: @js($event->city_id),
                cities: @js($event->country->cities),
                onCountryChange(event) {
                    axios.get(`/countries/${event.target.value}`)
                        .then(res => {
                            this.cities = res.data;
                        })
                        .catch(error => {
                            console.error('Error fetching cities', error);
                        });
                }
            }" enctype="multipart/form-data" class="p-4 bg-white dark:bg-slate-800 rounded-md">
                @csrf
                @method('PUT')
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                        <input type="text" id="title" name="title" class="bg-gray-800 text-gray-400 text-sm rounded-lg focus:ring-blue-500 w-full" value="{{ old('title', $event->title) }}">
                        @error('title')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="country_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a country</label>
                        <select name="country_id" id="country_id" x-on:change="onCountryChange" class="bg-gray-800 text-gray-400 text-sm rounded-lg focus:ring-blue-500 w-full">
                            <option>Choose a country</option>
                            @foreach ($countries as $country)
                            <option value="{{ $country->id }}" @selected($country->id === $event->country_id)>{{ $country->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="city_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a city</label>
                        <select name="city_id" id="city_id" x-model="city" class="bg-gray-800 text-gray-400 text-sm rounded-lg focus:ring-blue-500 w-full p-3">
                            <option>Choose a city</option>
                            <template x-for="city in cities" :key="city.id">
                                <option x-bind:value="city.id" x-text="city.name" :selected="city.id === cityId">
                                </option>
                            </template>
                        </select>
                        @error('city_id')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                        <input type="text" id="address" name="address" class="bg-gray-800 text-gray-400 text-sm rounded-lg focus:ring-blue-500 w-full" value="{{ old('address', $event->address) }}">
                        @error('address')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="file_input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload file</label>
                        <input type="file" id="file_input" name="image" class="block w-full text-sm bg-gray-400 rounded-lg cursor-pointer bg-gray">
                        @error('image')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="start_date" class="block mb-2 text-sm font-medium text-gray-400 dark:text-white">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="bg-gray-800 text-gray-400 text-sm rounded-lg focus:ring-blue-500 w-full" value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}">>
                        @error('start_date')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="bg-gray-800 text-gray-400 text-sm rounded-lg focus:ring-blue-500 w-full" value="{{ old('end_date', $event->end_date->format('Y-m-d')) }}">>
                        @error('end_date')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="start_time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Time</label>
                        <input type="time" id="start_time" name="start_time" class="bg-gray-800 text-gray-400 text-sm rounded-lg focus:ring-blue-500 w-full" value="{{ old('start_time', $event->start_time) }}">
                        @error('start_time')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="num_tickets" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No of Tickets:</label>
                        <input type="number" id="num_tickets" name="num_tickets" class="bg-gray-800 text-gray-400 text-sm rounded-lg focus:ring-blue-500 w-full" value="{{ old('num_tickets', $event->num_tickets) }}">
                        @error('num_tickets')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Tags</h3>
                        <ul
                            class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @foreach ($tags as $tag)
                                <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center pl-3">
                                        <input id="vue-checkbox-list" type="checkbox" name="tags[]"
                                        value="{{ $tag->id }}" @checked($event->hasTag($tag))
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label for="vue-checkbox-list"
                                            class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $tag->name }}</label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea rows="4" id="description" name="description" class="block p-2.5 w-full text-sm text-gray-400 bg-gray-800 rounded-lg focus:ring-blue-500">{{ $event->description }}</textarea>
                        @error('description')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="container py-10 px-10 mx-0 min-w-full flex flex-col items-center">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg px-4 py-2 w-3/12">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
