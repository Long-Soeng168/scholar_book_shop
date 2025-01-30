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

    {{-- Start Filter --}}
    <div class="grid grid-cols-2 gap-4 p-4 md:grid-cols-4">
        {{-- Start Author Select --}}
        <div class="relative w-full group">
            <x-input-label for="author" :value="__('Author')" />
            <div class="flex flex-1 gap-1 mt-1">
                <div class="flex justify-start flex-1 min-h-[2.5rem]">
                    <x-select-option class="author-select" wire:model.live='author_id' id="author" name="author_id">
                        <option wire:key='author' value="">Select Author...</option>
                        @forelse ($authorss as $author)
                            <option wire:key='{{ $author->id }}' value="{{ $author->id }}">
                                {{ $author->name }}
                            </option>
                        @empty
                            <option wire:key='noauthor' value=""> --No Author--</option>
                        @endforelse
                    </x-select-option>
                </div>
            </div>
        </div>
        {{-- End Author Select --}}

        {{-- Start Publisher Select --}}
        <div class="relative w-full group">
            <x-input-label for="publisher" :value="__('Publisher')" />
            <div class="flex flex-1 gap-1 mt-1 min-h-[2.5rem]">
                <div class="flex justify-start flex-1">
                    <x-select-option wire:model.live='publisher_id' id="publisher" name="publisher_id"
                        class="publisher-select">
                        <option wire:key='publisher' value="">Select Publisher...</option>
                        @forelse ($publishers as $publisher)
                            <option wire:key='{{ $publisher->id }}' value="{{ $publisher->id }}">
                                {{ $publisher->name }}</option>
                        @empty
                            <option wire:key='nopublisher' value=""> --No Publisher--</option>
                        @endforelse
                    </x-select-option>
                </div>
            </div>
        </div>
        {{-- End Publisher Select --}}

        {{-- Start Published From Year --}}
        <div class="relative z-0 w-full group">
            <x-input-label for="fromYear" :value="__('Published From Year')" />
            <div class="flex flex-1 gap-1 mt-1 min-h-[2.5rem]">
                <div class="flex justify-start flex-1">
                    <x-select-option wire:model.live='fromYear' id="fromYear" name="fromYear" class="fromYear-select">
                        <option wire:key='fromYear-select' value="">Select Year...</option>

                        @for ($year = date('Y'); $year >= 1800; $year--)
                            <option wire:key='{{ $year }}' value="{{ $year }}">
                                {{ $year }}</option>
                        @endfor
                    </x-select-option>
                </div>
            </div>
        </div>
        {{-- End Published From Year --}}

        {{-- Start Published To Year --}}
        <div class="relative z-0 w-full group">
            <x-input-label for="toYear" :value="__('Published To Year')" />
            <div class="flex flex-1 gap-1 mt-1 min-h-[2.5rem]">
                <div class="flex justify-start flex-1">
                    <x-select-option wire:model.live='toYear' id="toYear" name="toYear" class="toYear-select">
                        <option wire:key='toYear-select' value="">Select Year...</option>

                        @for ($year = date('Y'); $year >= 1800; $year--)
                            <option wire:key='{{ $year }}' value="{{ $year }}">
                                {{ $year }}</option>
                        @endfor
                    </x-select-option>
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:col-span-2 md:grid-cols-2">
            {{-- Start Category Select --}}
            <div class="relative w-full group">
                <x-input-label for="category_id" :value="__('Category')" />
                <div class="flex flex-1 gap-1 mt-1">
                    <div class="flex justify-start flex-1 min-h-[2.5rem]">
                        <x-select-option wire:model.live='category_id' id="category_id" name="category_id"
                            class="category-select">
                            <option wire:key='category' value="">Select Category...</option>
                            @forelse ($categories as $category)
                                <option wire:key='{{ $category->id }}' value="{{ $category->id }}">
                                    {{ $category->name }} {{ ' / ' . $category->name_kh }}
                                </option>
                            @empty
                                <option wire:key='nocateogry' value=""> --No Category--</option>
                            @endforelse
                        </x-select-option>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>
            {{-- End Category Select --}}

            {{-- Start Sub-Category Select --}}
            <div class="relative w-full group">
                <x-input-label for="sub_category_id" :value="__('Sub-Category')" />
                <div class="flex flex-1 gap-1 mt-1">
                    <div class="flex justify-start flex-1 min-h-[2.5rem]">
                        <x-select-option wire:model.live='sub_category_id' id="sub_category_id" name="category_id"
                            class="sub-category-select">
                            <option wire:key='sub-category' value="">
                                {{ $category_id ? 'Select Sub-Category...' : 'Select Category First' }}
                            </option>
                            @forelse ($subCategories as $subCategory)
                                <option wire:key='{{ $subCategory->id }}' value="{{ $subCategory->id }}">
                                    {{ $subCategory->name }} {{ ' / ' . $subCategory->name_kh }}
                                </option>
                            @empty
                                <option wire:key='nosub-category' value="">--No Category--</option>
                            @endforelse
                        </x-select-option>
                    </div>

                </div>
                <x-input-error :messages="$errors->get('sub_category_id')" class="mt-2" />
            </div>
            {{-- End Sub-Category Select --}}
        </div>

        <div class="flex-1">
            <x-input-label for="priceFrom" :value="__('Price From')" />
            <x-text-input wire:model.live.debounce.300ms='priceFrom' id="priceFrom" class="block w-full mt-1" type="number"
                name="priceFrom" placeholder='Example : 2$' :value="old('priceFrom')" autocomplete="priceFrom" />
            <x-input-error :messages="$errors->get('priceFrom')" class="mt-2" />
        </div>
        <div class="flex-1">
            <x-input-label for="priceTo" :value="__('Price To')" />
            <x-text-input wire:model.live.debounce.300ms='priceTo' id="priceTo" class="block w-full mt-1" type="number"
                name="priceTo" placeholder='Example : 7$' :value="old('priceTo')" autocomplete="priceTo" />
            <x-input-error :messages="$errors->get('priceTo')" class="mt-2" />
        </div>

        <div class="relative z-0 w-full group">
            <x-input-label for="orderBy" :value="__('Order By')" />
            <div class="flex flex-1 gap-1 mt-1 min-h-[2.5rem]">
                <div class="flex justify-start flex-1">
                    <x-select-option wire:model.live='orderBy' id="orderBy" name="orderBy" class="orderBy-select">
                        <option value="">Select Order</option>
                        <option value="totalViewDesc">Total View (Descending 9->0)</option>
                        <option value="totalViewAsc">Total View (Ascending 0->9)</option>
                        <option value="totalSaleDesc">Total Sale (Descending 9->0)</option>
                        <option value="totalSaleAsc">Total Sale (Ascending 0->9)</option>
                        <option value="totalPriceDesc">Total Price (Descending 9->0)</option>
                        <option value="totalPriceAsc">Total Price (Ascending 0->9)</option>
                    </x-select-option>
                </div>
            </div>
        </div>
        {{-- End Published To Year --}}
    </div>
    <div>
        <ul>
            <li>author id : {{ $author_id }}</li>
            <li>publisher id : {{ $publisher_id }}</li>
            <li>fromYear : {{ $fromYear }}</li>
            <li>toYear : {{ $toYear }}</li>
            <li>category_id : {{ $category_id }}</li>
            <li>sub_category_id : {{ $sub_category_id }}</li>
            <li>priceFrom : {{ $priceFrom }}</li>
            <li>priceTo : {{ $priceTo }}</li>
            <li>orderBy : {{ $orderBy }}</li>
        </ul>
    </div>
    {{-- End Filter --}}
    <div
        class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
        <div class="w-full md:w-1/2">
            <form class="flex items-center gap-4">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                            viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" id="simple-search" wire:model.live.debounce.300ms='search'
                        class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Search...">
                </div>

            </form>
        </div>
        <div
            class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">

            @can('create item')
                <x-primary-button href="{{ url('admin/books/create') }}">
                    <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    Add New
                </x-primary-button>
            @endcan


            <div class="flex items-center w-full space-x-3 md:w-auto">
                <button id="filterDropdownButton" wire:click="export"
                    class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-file-up">
                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                        <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                        <path d="M12 12v6" />
                        <path d="m15 15-3-3-3 3" />
                    </svg>
                    Export
                </button>

            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3">No</th>
                    <th scope="col" class="px-4 py-3">Image</th>
                    <th scope="col" class="px-4 py-3">File</th>
                    <th scope="col" class="px-4 py-3 " wire:click='setSortBy("title")'>
                        <div class="flex items-center cursor-pointer">

                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-chevrons-up-down">
                                <path d="m7 15 5 5 5-5" />
                                <path d="m7 9 5-5 5 5" />
                            </svg>
                            Title
                        </div>
                    </th>
                    <th scope="col" class="px-4 py-3">Internal Reference</th>
                    <th scope="col" class="px-4 py-3">Price</th>
                    <th scope="col" class="px-4 py-3 text-center">ISBN</th>
                    <th scope="col" class="px-4 py-3">Author</th>
                    <th scope="col" class="px-4 py-3">Publisher</th>
                    {{-- <th scope="col" class="px-4 py-3">Access</th> --}}
                    {{-- <th scope="col" class="px-4 py-3 text-center">For Sale</th> --}}
                    <th scope="col" class="px-4 py-3 text-center">Status</th>
                    <th scope="col" class="px-4 py-3 text-center">Total View</th>
                    <th scope="col" class="py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr wire:key='{{ $item->id }}'
                        class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="w-4 px-4 py-3">
                            {{ $loop->iteration }}
                        </td>
                        <th scope="row"
                            class="flex items-center px-4 py-2 font-medium text-gray-900 dark:text-white">
                            <a href="{{ asset('assets/images/isbn/' . $item->image) ?? 'N/A' }}" class="glightbox">
                                <img src="{{ asset('assets/images/isbn/thumb/' . $item->image) ?? 'N/A' }}"
                                    alt="Image" class="object-contain h-10 mr-3 aspect-[16/9]">
                            </a>
                        </th>
                        <x-table-data>
                            @if ($item->file != null)
                                <span class="w-4 px-4 py-3 font-semibold text-green-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="#008009" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-check-2">
                                        <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                        <path d="m3 15 2 2 4-4" />
                                    </svg>
                                </span>
                            @else
                                <span class="w-4 px-4 py-3 font-semibold text-yellow-600 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="#fa0000" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-file-x-2">
                                        <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                        <path d="m8 12.5-5 5" />
                                        <path d="m3 12.5 5 5" />
                                    </svg>
                                </span>
                            @endif
                        </x-table-data>
                        <x-table-data value="{{ $item->title ?? 'N/A' }}" />
                        <x-table-data value="{{ $item->internal_reference ?? 'N/A' }}" />
                        <x-table-data value="$ {{ $item->price ?? 'N/A' }}" class="text-red-400 whitespace-nowrap" />
                        <x-table-data value="{{ $item->isbn ?? 'N/A' }}" />
                        <x-table-data class="text-center" value="{{ $item->author?->name ?? 'N/A' }}" />
                        <x-table-data class="text-center" value="{{ $item->publisher?->name ?? 'N/A' }}" />


                        {{-- <td wire:key='{{ rand() }}' class="text-center">
                            <button data-modal-target="popup-modal-{{ $item->id }}"
                                data-modal-toggle="popup-modal-{{ $item->id }}">
                                @if ($item->is_for_sell == 1)
                                    <span class="w-4 px-4 py-3 font-semibold text-green-700">
                                        For-Sell
                                    </span>
                                @else
                                    <span class="w-4 px-4 py-3 font-semibold text-yellow-600 whitespace-nowrap">
                                        Not-For-Sell
                                    </span>
                                @endif
                            </button>

                            @can('update item')
                                <div id="popup-modal-{{ $item->id }}" tabindex="-1"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-md max-h-full p-4">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <button type="button"
                                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="popup-modal-{{ $item->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                            </button>
                                            <div class="p-4 text-center md:p-5">
                                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-200"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                    Update Status</strong>
                                                </h3>
                                                <button data-modal-hide="popup-modal-{{ $item->id }}" type="button"
                                                    wire:click='updateForSell({{ $item->id }}, 0)'
                                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Not-For-Sell
                                                </button>
                                                <button data-modal-hide="popup-modal-{{ $item->id }}" type="button"
                                                    wire:click='updateForSell({{ $item->id }}, 1)'
                                                    class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    For-Sell
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endcan

                        </td> --}}
                        {{-- <td wire:key='{{ rand() }}' class="text-center">
                            <button data-modal-target="popup-modal-free-status-{{ $item->id }}"
                                data-modal-toggle="popup-modal-free-status-{{ $item->id }}">
                                @if ($item->is_free == 1)
                                    <span class="w-4 px-4 py-3 font-semibold text-green-700 whitespace-nowrap">
                                        Free Assess
                                    </span>
                                @else
                                    <span class="w-4 px-4 py-3 font-semibold text-yellow-600 whitespace-nowrap">
                                        Not-Free
                                    </span>
                                @endif
                            </button>

                            @can('update item')
                                <div id="popup-modal-free-status-{{ $item->id }}" tabindex="-1"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-md max-h-full p-4">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <button type="button"
                                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="popup-modal-free-status-{{ $item->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                            </button>
                                            <div class="p-4 text-center md:p-5">
                                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-200"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                    Update Status</strong>
                                                </h3>
                                                <button data-modal-hide="popup-modal-free-status-{{ $item->id }}"
                                                    type="button" wire:click='updateIsFree({{ $item->id }}, 0)'
                                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Not-Free
                                                </button>
                                                <button data-modal-hide="popup-modal-free-status-{{ $item->id }}"
                                                    type="button" wire:click='updateIsFree({{ $item->id }}, 1)'
                                                    class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Free Access
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        </td> --}}
                        <td wire:key='{{ rand() }}' class="text-center">

                            <button data-modal-target="popup-modal-user-{{ $item->id }}"
                                data-modal-toggle="popup-modal-user-{{ $item->id }}">
                                @if ($item->status == 1)
                                    <span class="w-4 px-4 py-3 font-semibold text-green-700">
                                        Public
                                    </span>
                                @else
                                    <span class="w-4 px-4 py-3 font-semibold text-yellow-600 whitespace-nowrap">
                                        Not-Public
                                    </span>
                                @endif
                            </button>

                            @can('update item')
                                <div id="popup-modal-user-{{ $item->id }}" tabindex="-1"
                                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-md max-h-full p-4">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <button type="button"
                                                class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="popup-modal-user-{{ $item->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                            </button>
                                            <div class="p-4 text-center md:p-5">
                                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-200"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                    Update Status</strong>
                                                </h3>
                                                <button data-modal-hide="popup-modal-user-{{ $item->id }}"
                                                    type="button" wire:click='updateStatus({{ $item->id }}, 0)'
                                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Not-Public
                                                </button>
                                                <button data-modal-hide="popup-modal-user-{{ $item->id }}"
                                                    type="button" wire:click='updateStatus({{ $item->id }}, 1)'
                                                    class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    Public
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endcan

                        </td>
                        <x-table-data class="text-center" value="{{ $item->view_count }}" />

                        <td class="px-6 py-4">
                            <div class="flex items-start justify-center gap-3">

                                <div class="pb-1" x-data="{ tooltip: false }">
                                    <!-- Modal toggle -->
                                    <a href="{{ 'https://www.scholarkh.com/en/products/' . $item->id }}"
                                        @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-eye">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </a>

                                    <!-- View tooltip -->
                                    <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                                        class="absolute z-10 inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm dark:bg-gray-700"
                                        style="display: none;">
                                        View
                                    </div>
                                </div>

                                @can('update item')
                                    <div class="pb-1" x-data="{ tooltip: false }">
                                        <!-- Modal toggle -->
                                        <a href="{{ url('admin/books_images/' . $item->id) }}"
                                            @mouseenter="tooltip = true" @mouseleave="tooltip = false" class="relative">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-plus-circle">
                                                <circle cx="12" cy="12" r="10" />
                                                <path d="M8 12h8" />
                                                <path d="M12 8v8" />
                                            </svg>
                                            <!-- View tooltip -->
                                            <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 transform scale-90"
                                                x-transition:enter-end="opacity-100 transform scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="opacity-100 transform scale-100"
                                                x-transition:leave-end="opacity-0 transform scale-90"
                                                class="absolute z-10 inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm dark:bg-gray-700 whitespace-nowrap"
                                                style="display: none;">
                                                Add Image
                                            </div>
                                        </a>


                                    </div>
                                @endcan

                                @can('delete item')
                                    <div class="pb-1" x-data="{ tooltip: false }">
                                        <!-- Modal toggle -->
                                        <a wire:click="delete({{ $item->id }})"
                                            wire:confirm="Are you sure? you want to delete : {{ $item->title }}"
                                            @mouseenter="tooltip = true" @mouseleave="tooltip = false"
                                            class="text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-trash">
                                                <path d="M3 6h18" />
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                            </svg>
                                        </a>

                                        <!-- View tooltip -->
                                        <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                                            class="absolute z-[9999] inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm dark:bg-gray-700 whitespace-nowrap"
                                            style="display: none;">
                                            Delete
                                        </div>
                                    </div>
                                @endcan

                                @can('update item')
                                    <div class="pb-1" x-data="{ tooltip: false }">
                                        <!-- Modal toggle -->
                                        <a href="{{ url('admin/books/' . $item->id . '/edit') }}"
                                            @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="lucide lucide-file-pen-line">
                                                <path d="m18 5-3-3H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2" />
                                                <path d="M8 18h1" />
                                                <path d="M18.4 9.6a2 2 0 1 1 3 3L17 17l-4 1 1-4Z" />
                                            </svg>
                                        </a>
                                        <!-- View tooltip -->
                                        <div x-show="tooltip" x-transition:enter="transition ease-out duration-200"
                                            class="absolute z-[9999] inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm dark:bg-gray-700 whitespace-nowrap"
                                            style="display: none;">
                                            Edit
                                        </div>
                                    </div>
                                @endcan

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-4">No Data...</td>
                    </tr>
                @endforelse


            </tbody>
        </table>

        <div class="p-4">
            <div class="max-w-[200px] my-2 flex gap-2 items-center">
                <label for="countries"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white whitespace-nowrap">Record per
                    page : </label>
                <select id="countries" wire:model.live='perPage'
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="70">70</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div>{{ $items->links() }}</div>
        </div>
    </div>
</div>

@script
    <script>
        $(document).ready(function() {
            document.addEventListener('livewire:updated', event => {
                console.log('updated'); // Logs 'Livewire component updated' to browser console
                initFlowbite();
            });
        });
        $(document).ready(function() {
            document.addEventListener('livewire:updatedStatus', event => {
                console.log('updated'); // Logs 'Livewire component updated' to browser console
                initFlowbite();
                location.reload();
            });
        });
        initFlowbite();
        // Function to check for URL changes
        function checkUrlChange() {
            let currentUrl = window.location.href;

            // Check for URL changes every 500ms
            setInterval(() => {
                if (window.location.href !== currentUrl) {
                    currentUrl = window.location.href;
                    console.log('URL changed:', currentUrl);

                    // Reinitialize your functions
                    initFlowbite();
                    initSelect2();
                }
            }, 500); // Adjust the interval as needed
        }

        // Start checking for URL changes
        checkUrlChange();

        function initSelect2() {
            $(document).ready(function() {
                $('.category-select').select2();
                $('.category-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('category_id', data);
                });

                $('.sub-category-select').select2();
                $('.sub-category-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('sub_category_id', data);
                });

                $('.author-select').select2();
                $('.author-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('author_id', data);
                });
                $('.publisher-select').select2();
                $('.publisher-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('publisher_id', data);
                });

                $('.fromYear-select').select2();
                $('.fromYear-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('fromYear', data);
                });
                $('.toYear-select').select2();
                $('.toYear-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('toYear', data);
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


@script
    <script></script>
@endscript
