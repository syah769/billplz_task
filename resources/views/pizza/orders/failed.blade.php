<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Failed') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Order Details</h3>
                    <p><strong>Order ID:</strong> {{ $order->id }}</p>
                    <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Total Amount:</strong> RM{{ number_format($order->total_amount, 2) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>

                    <p class="text-red-600 font-semibold mt-4">We're sorry, but there was an issue processing your payment. Please try again or contact customer support.</p>

                    <a href="{{ route('pizza.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-6">
                        Try Again
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
