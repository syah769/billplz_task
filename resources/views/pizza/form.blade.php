<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Pizza') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('pizza.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
                            <input type="text" name="customer_name" id="customer_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('customer_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="size" class="block text-sm font-medium text-gray-700">Pizza Size</label>
                            <select name="size" id="size" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="" disabled selected>Please choose</option>
                                <option value="small">Small (RM 15)</option>
                                <option value="medium">Medium (RM 22)</option>
                                <option value="large">Large (RM 30)</option>
                            </select>
                            @error('size')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="pepperoni" class="inline-flex items-center">
                                <input type="hidden" name="pepperoni" value="0">
                                <input type="checkbox" name="pepperoni" id="pepperoni" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Add Pepperoni (RM 3 for small, RM 5 for medium)</span>
                            </label>
                            @error('pepperoni')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="extra_cheese" class="inline-flex items-center">
                                <input type="hidden" name="extra_cheese" value="0">
                                <input type="checkbox" name="extra_cheese" id="extra_cheese" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Add Extra Cheese (RM 6)</span>
                            </label>
                            @error('extra_cheese')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <p id="total_amount" class="text-lg font-semibold">Total Amount: RM0.00</p>
                        </div>

                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Order Pizza
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sizeSelect = document.getElementById('size');
        const pepperoniCheckbox = document.getElementById('pepperoni');
        const extraCheeseCheckbox = document.getElementById('extra_cheese');
        const totalAmountElement = document.getElementById('total_amount');

        function calculateTotalAmount() {
            let totalAmount = 0;

            switch (sizeSelect.value) {
                case 'small':
                    totalAmount += 15;
                    break;
                case 'medium':
                    totalAmount += 22;
                    break;
                case 'large':
                    totalAmount += 30;
                    break;
            }

            if (pepperoniCheckbox.checked) {
                if (sizeSelect.value === 'small') {
                    totalAmount += 3;
                } else if (sizeSelect.value === 'medium') {
                    totalAmount += 5;
                }
            }

            if (extraCheeseCheckbox.checked) {
                totalAmount += 6;
            }

            totalAmountElement.textContent = `Total Amount: RM ${totalAmount.toFixed(2)}`;
        }

        sizeSelect.addEventListener('change', calculateTotalAmount);
        pepperoniCheckbox.addEventListener('change', calculateTotalAmount);
        extraCheeseCheckbox.addEventListener('change', calculateTotalAmount);

        calculateTotalAmount();
    });
</script>
