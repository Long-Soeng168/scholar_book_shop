<div>
    @if (session('success'))
        <div class="fixed top-[5rem] right-4 z-[999999] " wire:key="{{ rand() }}" x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 7000)">
            <div x-show="show" id="alert-2"
                class="flex items-center p-4 mb-4 text-green-800 border border-green-500 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <div class="ml-2">
                    {{ session('success') }}
                </div>
                <button type="button" @click="show = false"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-2" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        {{-- @dd(session()->has('error')) --}}
        <div class="fixed top-[5rem] right-4 z-[999999] " wire:key="{{ rand() }}" x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 7000)">
            <div x-show="show" id="alert-2"
                class="flex items-center p-4 mb-4 text-red-800 border border-red-500 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <div class="ml-2">
                    @foreach (session('error') as $error)
                        <div class="text-sm font-medium ms-3">
                            - {{ $error }}
                        </div>
                    @endforeach

                    {{ session()->forget('errors') }}



                </div>
                <button type="button" @click="show = false"
                    class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-2" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    @endif
    <form class="w-full" enctype="multipart/form-data">
        @csrf

        <div class="">
            <section class="mt-8">
                <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-2">
                    {{-- Start Products Select --}}
                    <div class="relative w-full col-span-2 group">
                        <x-input-label for="product" :value="__('Product')" />
                        <div class="flex flex-1 col-span-2 gap-1 mt-1" wire:ignore>
                            <div class="flex justify-start flex-1 h-full">
                                <x-select-option class="product-select" id="product" name="product_id">
                                    <option wire:key='product' value="">Select Product...</option>
                                    @forelse ($products as $product)
                                        <option wire:key='{{ $product->id }}' value="{{ $product->id }}">
                                            {{ $product->title }}
                                        </option>
                                    @empty
                                        <option wire:key='noproduct' value=""> --No Product--</option>
                                    @endforelse
                                </x-select-option>
                            </div>
                        </div>
                        <div>
                            <table
                                class="w-full border border-collapse border-gray-300 table-auto dark:border-gray-600">
                                <thead>
                                    <tr class="bg-gray-200 dark:bg-gray-700">
                                        <th
                                            class="px-4 py-2 text-left border border-gray-300 dark:border-gray-600 dark:text-gray-200">
                                            Title</th>
                                        <th
                                            class="px-4 py-2 text-left border border-gray-300 dark:border-gray-600 dark:text-gray-200">
                                            Quantity</th>
                                        <th
                                            class="px-4 py-2 text-left border border-gray-300 dark:border-gray-600 dark:text-gray-200">
                                            Unit Price</th>
                                        <th
                                            class="px-4 py-2 text-left border border-gray-300 dark:border-gray-600 dark:text-gray-200">
                                            Subtotal</th>
                                        <th
                                            class="px-4 py-2 text-left border border-gray-300 dark:border-gray-600 dark:text-gray-200">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($selectedProducts as $index => $item)
                                        @php
                                            $subtotal = $item['price'] * $item['quantity'];
                                            $total += $subtotal;
                                        @endphp
                                        <tr wire:key="{{ $item['id'] }}"
                                            class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td
                                                class="px-4 py-2 border border-gray-300 dark:border-gray-600 dark:text-gray-200">
                                                {{ $item['title'] }}</td>
                                            <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">
                                                <input type="number"
                                                    wire:change="updateProduct({{ $item['id'] }}, 'quantity', $event.target.value)"
                                                    value="{{ $item['quantity'] }}" placeholder="Quantity"
                                                    class="w-full px-2 py-1 border rounded focus:ring focus:ring-blue-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500">
                                            </td>
                                            <td class="px-4 py-2 border border-gray-300 dark:border-gray-600">
                                                <input type="text"
                                                    wire:change="updateProduct({{ $item['id'] }}, 'price', $event.target.value)"
                                                    value="{{ $item['price'] }}" placeholder="Unit Price"
                                                    class="w-full px-2 py-1 border rounded focus:ring focus:ring-blue-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500">
                                            </td>
                                            <td
                                                class="px-4 py-2 font-semibold border border-gray-200 dark:border-gray-600 dark:text-gray-200">
                                                ${{ number_format($subtotal, 2) }}
                                            </td>
                                            <td
                                                class="px-4 py-2 font-semibold border border-gray-200 dark:border-gray-600">
                                                <button type="button" wire:key='removeProduct-{{ $index }}'
                                                    wire:click="removeProduct({{ $index }})"
                                                    class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">Remove</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr
                                        class="text-sm font-bold text-gray-800 bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                                        <td colspan="3"
                                            class="px-4 py-2 text-right border border-gray-200 dark:border-gray-600">
                                            Total:</td>
                                        <td colspan="2"
                                            class="px-4 py-2 border border-gray-200 dark:border-gray-600">
                                            ${{ number_format($total, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                    {{-- End Products Select --}}
                    <div class="relative w-full mt-5 group">
                        <x-input-label for="supplier" :value="__('Supplier')" />
                        <div class="flex flex-1 gap-1 mt-1">
                            <div class="flex justify-start flex-1 h-11">
                                <x-select-option wire:model.live='supplier_id' id="supplier" name="supplier_id"
                                    class="supplier-select">
                                    <option wire:key='supplier' value="">Select Supplier...</option>
                                    @forelse ($suppliers as $supplier)
                                        <option wire:key='{{ $supplier->id }}' value="{{ $supplier->id }}">
                                            {{ $supplier->name }}</option>
                                    @empty
                                        <option wire:key='nosupplier' value=""> --No Supplier--</option>
                                    @endforelse
                                </x-select-option>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                    </div>

                    <!-- Status Selection -->
                    <div class="relative w-full mt-5 group">
                        <x-input-label for="status" :value="__('Status')" />
                        <div class="flex flex-1 gap-1 mt-1">
                            <div class="flex justify-start flex-1">
                                <x-select-option wire:model.live='status' id="status" name="status"
                                    class="status-select">
                                    <option wire:key='received' value="1">Received</option>
                                    <option wire:key='not-received' value="0">Not-Received</option>
                                </x-select-option>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="purchase_date" :value="__('Purchase Date')" /><span class="text-red-400">*</span>
                        <x-text-input wire:model='purchase_date' id="purchase_date" class="block w-full mt-1"
                            type="date" name="purchase_date" :value="old('purchase_date')" autocomplete="purchase_date" />
                        <x-input-error :messages="$errors->get('purchase_date')" class="mt-2" />
                    </div>
                </div>


            </section>
            {{-- Start supplier Select --}}



        </div>
        <!-- End Name -->


        <div class="mt-5">
            <x-outline-button wire:ignore href="{{ URL::previous() }}">
                Go back
            </x-outline-button>
            <button wire:loading.class="cursor-not-allowed" wire:click.prevent="save"
                wire:target="save, image, file, handleSelectProduct, updateProduct, removeProduct"
                wire:loading.attr="disabled"
                class = 'text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800'>
                Save
            </button>
            <span wire:target="save" wire:loading>
                <img class="inline w-6 h-6 text-white me-2 animate-spin"
                    src="{{ asset('assets/images/reload.png') }}" alt="reload-icon">
                Saving
            </span>
            <span wire:target="handleSelectProduct, updateProduct, removeProduct" wire:loading>
                <img class="inline w-6 h-6 text-white me-2 animate-spin"
                    src="{{ asset('assets/images/reload.png') }}" alt="reload-icon">
                Loading
            </span>
            <span wire:target="file,image" wire:loading class="dark:text-white">
                <img class="inline w-6 h-6 text-white me-2 animate-spin"
                    src="{{ asset('assets/images/reload.png') }}" alt="reload-icon">
                On Uploading File...
            </span>
        </div>
    </form>

</div>

@script
    <script>
        $(document).ready(function() {
            document.addEventListener('livewire:updated', event => {
                console.log('updated'); // Logs 'Livewire component updated' to browser console
                initFlowbite();
            });
        });

        function initSelect2() {
            $(document).ready(function() {
                $('.supplier-select').select2();
                $('.supplier-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('supplier_id', data);
                });

                $('.product-select').select2();
                $('.product-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.handleSelectProduct(data)
                    // @this.set('product_id', data);
                });
            });
        }
        initSelect2();

        $(document).ready(function() {
            document.addEventListener('livewire:updated', event => {
                console.log('updated'); // Logs 'Livewire component updated' to browser console
                initSelect2();
                initFlowbite();
            });
        });
    </script>
@endscript
