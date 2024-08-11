<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Password Generator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('generated_password'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                            <span class="font-bold">Generated Password:</span>
                            <span class="ml-2 font-mono bg-white px-2 py-1 rounded border border-gray-200">{{ session('generated_password') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.generate') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="length" class="block text-sm font-medium text-gray-700">
                                Password Length
                            </label>
                            <input type="number" name="length" id="length" value="12" min="4" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <div class="space-y-4">
                            <p class="block text-sm font-medium text-gray-700">Include:</p>
                            <div class="flex flex-wrap gap-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="use_small" class="form-checkbox text-indigo-600" checked>
                                    <span class="ml-2 text-gray-700">Small Letters</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="use_capital" class="form-checkbox text-indigo-600" checked>
                                    <span class="ml-2 text-gray-700">Capital Letters</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="use_numbers" class="form-checkbox text-indigo-600" checked>
                                    <span class="ml-2 text-gray-700">Numbers</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="use_symbols" class="form-checkbox text-indigo-600" checked>
                                    <span class="ml-2 text-gray-700">Symbols</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="px-4 py-2 border border-purple-600 rounded-md text-sm font-medium text-black bg-white hover:bg-purple-100 focus:ring-2 focus:ring-purple-500">
                                Generate Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
