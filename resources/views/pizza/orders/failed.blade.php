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
                    <h3 class="text-2xl font-semibold mb-6">Order Summary</h3>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-600">Order #</p>
                            <p class="font-semibold">PZ-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Customer Name</p>
                            <p class="font-semibold">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Amount</p>
                            <p class="font-semibold">RM {{ number_format($order->total_amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="font-semibold">{{ ucfirst($order->status) }}</p>
                        </div>
                    </div>

                    <h4 class="text-xl font-semibold mt-8 mb-4">Pizza Details</h4>
                    @foreach ($order->pizzas as $index => $pizza)
                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <h5 class="font-semibold mb-2">Pizza #{{ $index + 1 }}</h5>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <p class="text-sm text-gray-600">Size</p>
                                    <p>{{ ucfirst($pizza->size) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Price</p>
                                    <p>RM {{ number_format($pizza->base_price, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Pepperoni</p>
                                    <p>{{ $pizza->pepperoni ? 'Yes (+RM ' . number_format($pizza->pepperoni_price, 2) . ')' : 'No' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Extra Cheese</p>
                                    <p>{{ $pizza->extra_cheese ? 'Yes (+RM ' . number_format($pizza->extra_cheese_price, 2) . ')' : 'No' }}</p>
                                </div>
                            </div>
                            <p class="mt-2 font-semibold">Total: RM {{ number_format($pizza->total_price, 2) }}</p>
                        </div>
                    @endforeach

                    <div class="mt-6">
                        <p class="text-sm text-gray-600">Payment Status</p>
                        <p class="font-semibold">{{ ucfirst($order->payment->status) }}</p>
                    </div>

                    <p class="text-red-600 font-semibold mt-6">We're sorry, but there was an issue processing your payment. Please try again or contact customer support.</p>

                    <div class="flex mt-8">
                        <a href="{{ route('pizza.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                            Try Again
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
