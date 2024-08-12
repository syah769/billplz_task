<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Completed') }}
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
                                    <p>{{ $pizza->pepperoni ? 'Yes (+RM ' . number_format($pizza->pepperoni_price, 2) . ')' : 'No' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Extra Cheese</p>
                                    <p>{{ $pizza->extra_cheese ? 'Yes (+RM ' . number_format($pizza->extra_cheese_price, 2) . ')' : 'No' }}
                                    </p>
                                </div>
                            </div>
                            <p class="mt-2 font-semibold">Total: RM {{ number_format($pizza->total_price, 2) }}</p>
                        </div>
                    @endforeach

                    <div class="mt-6">
                        <p class="text-sm text-gray-600">Payment Status</p>
                        <p class="font-semibold">{{ ucfirst($payment->status) }}</p>
                    </div>

                    @if ($order->status === \App\Models\Order::STATUS_COMPLETED)
                        <p class="text-green-600 font-semibold mt-6">Thank you for your order! Your payment has been
                            processed successfully.</p>

                        <div class="flex mt-8">
                            <a href="{{ route('pizza.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-4">
                                Order Another Pizza
                            </a>

                            <a href="{{ route('order.print', $order->order_id) }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                </svg>
                                Print Receipt
                            </a>
                        </div>
                    @elseif($order->status === \App\Models\Order::STATUS_FAILED)
                        <p class="text-red-600 font-semibold mt-6">We're sorry, but there was an issue processing your
                            payment. Please try again or contact customer support.</p>
                    @else
                        <p class="text-yellow-600 font-semibold mt-6">Your order is being processed. Please wait for
                            confirmation.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
