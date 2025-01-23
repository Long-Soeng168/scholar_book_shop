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
                    <div class="md:col-span-2">
                        <x-input-label for="title" :value="__('messages.title')" /><span class="text-red-400">*</span>
                        <x-text-input wire:model='title' id="title" class="block w-full mt-1" type="text"
                            name="title" :value="old('title')" autocomplete="title" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="short_description" :value="__('Short Description')" />
                        <textarea wire:model='short_description' class="w-full p-2 mt-1 border rounded bg-gray-50"
                            placeholder="Enter Short Description">{{ $short_description }}</textarea>
                        <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
                    </div>
                    {{-- Start Author Select --}}
                    <div class="relative w-full group">
                        <x-input-label for="author" :value="__('Author')" />
                        <div class="flex flex-1 gap-1 mt-1">
                            <div class="flex justify-start flex-1">
                                <x-select-option class="author-select" wire:model.live='author_id' id="author"
                                    name="author_id">
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
                            <button type="button" data-modal-target="author_modal" data-modal-toggle="author_modal"
                                class="rounded-md text-sm p-2.5 font-medium text-center text-white bg-blue-700 ">
                                Add
                            </button>

                            <!-- Start Author modal -->
                            <div id="author_modal" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full lg:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-md max-h-full p-4">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between p-4 border-b rounded-t lg:p-5 dark:border-gray-600">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                Create Author
                                            </h3>
                                            <button type="button"
                                                class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-toggle="author_modal">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-4 lg:p-5">
                                            <div class="grid grid-cols-2 gap-4 mb-4 ">
                                                <div class="col-span-2">
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                                    <input wire:key="{{ rand() }}" type="text"
                                                        name="name" id="name" wire:model='newAuthorName'
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                        placeholder="Name">
                                                </div>

                                                <div class="col-span-2 sm:col-span-2">
                                                    <label for="category"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                                                    <select id="category" wire:model='newAuthorGender'
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                        <option value="">Select gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="n/a">N/A</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button data-modal-target="author_modal"
                                                    data-modal-toggle="author_modal" type="button"
                                                    wire:click='saveNewAuthor' wire:target="saveNewAuthor"
                                                    wire:loading.attr="disabled"
                                                    class="text-white mt-2 inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    <svg class="w-5 h-5 me-1 -ms-1" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Add New
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Author modal -->
                        </div>
                        <x-input-error :messages="$errors->get('author_id')" class="mt-2" />
                    </div>
                    {{-- End Author Select --}}

                    {{-- Start Publisher Select --}}
                    <div class="relative w-full group">
                        <x-input-label for="publisher" :value="__('Publisher')" />
                        <div class="flex flex-1 gap-1 mt-1">
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
                            <button type="button" data-modal-target="publisher_modal"
                                data-modal-toggle="publisher_modal"
                                class="rounded-md text-sm p-2.5 font-medium text-center text-white bg-blue-700 ">
                                Add
                            </button>

                            <!-- Start Publisher modal -->
                            <div id="publisher_modal" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full lg:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-md max-h-full p-4">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between p-4 border-b rounded-t lg:p-5 dark:border-gray-600">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                Create Publisher
                                            </h3>
                                            <button type="button"
                                                class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-toggle="publisher_modal">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-4 lg:p-5">
                                            <div class="grid grid-cols-2 gap-4 mb-4 ">
                                                <div class="col-span-2">
                                                    <label for="name"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                                    <input wire:key="{{ rand() }}" type="text"
                                                        name="name" id="name" wire:model='newPublisherName'
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                        placeholder="Name">
                                                </div>

                                                <div class="col-span-2 sm:col-span-2">
                                                    <label for="category"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                                                    <select id="category" wire:model='newPublisherGender'
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                        <option value="">Select gender</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                        <option value="n/a">N/A</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <button data-modal-target="publisher_modal"
                                                    data-modal-toggle="publisher_modal" type="button"
                                                    wire:click='saveNewPublisher' wire:target="saveNewPublisher"
                                                    wire:loading.attr="disabled"
                                                    class="text-white mt-2 inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    <svg class="w-5 h-5 me-1 -ms-1" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Add New
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Publisher modal -->
                        </div>
                        <x-input-error :messages="$errors->get('publisher_id')" class="mt-2" />
                    </div>
                    {{-- End Publisher Select --}}
                    <div>
                        <x-input-label wire:model='isbn' for="isbn" :value="__('messages.isbn')" />
                        <x-text-input wire:model='isbn' id="isbn" class="block w-full mt-1" type="text"
                            name="isbn" placeholder='Example: 9780596520687' :value="old('isbn')"
                            autocomplete="isbn" />
                        <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label wire:model='tsin' for="tsin" :value="__('messages.tsin')" />
                        <x-text-input wire:model='tsin' id="tsin" class="block w-full mt-1" type="text"
                            name="tsin" placeholder='Example: 9780596520687' :value="old('tsin')"
                            autocomplete="tsin" />
                        <x-input-error :messages="$errors->get('tsin')" class="mt-2" />
                    </div>
                    <div class="">
                        <x-input-label for="numberOfPages" :value="__('messages.numberOfPages')" />
                        <x-text-input wire:model='number_of_pages' id="numberOfPages" class="block w-full mt-1"
                            type="text" placeholder='Example: 190' name="numberOfPages" type='number'
                            :value="old('numberOfPages')" autocomplete="numberOfPages" />
                        <x-input-error :messages="$errors->get('number_of_pages')" class="mt-2" />
                    </div>
                    <div class="">
                        <x-input-label for="price" :value="__('messages.price') . ' ($)'" /><span class="text-red-400">*</span>
                        <x-text-input wire:model='price' id="price" class="block w-full mt-1" type="number"
                            name="price" placeholder='Example : 7$' :value="old('price')" autocomplete="price" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>
                    <div class="">
                        <x-input-label for="discount" :value="__('Discount')" />
                        <x-text-input wire:model='discount' id="discount" class="block w-full mt-1" type="number"
                            name="discount" placeholder='Example: 30%' :value="old('discount')" autocomplete="discount" />
                        <x-input-error :messages="$errors->get('discount')" class="mt-2" />
                    </div>
                    {{-- <div class="">
                        <x-input-label for="publicationDate" :value="__('messages.publicationDate')" />
                        <x-text-input wire:model='publication_date' id="publicationDate" class="block w-full mt-1"
                            type="date" name="publicationDate" :value="old('publicationDate')"
                            autocomplete="publicationDate" />
                        <x-input-error :messages="$errors->get('publication_date')" class="mt-2" />
                    </div> --}}
                    {{-- Start Year Select --}}
                    <div class="relative z-0 w-full group">
                        <x-input-label for="year" :value="__('Publication Year')" />
                        <div class="flex flex-1 gap-1 mt-1 min-h-[2.5rem]">
                            <div class="flex justify-start flex-1">
                                <x-select-option wire:model.live='year' id="year" name="year"
                                    class="year-select">
                                    <option wire:key='year-select' value="">Select Year...</option>

                                    @for ($year = date('Y'); $year >= 1800; $year--)
                                        <option wire:key='{{ $year }}' value="{{ $year }}">
                                            {{ $year }}</option>
                                    @endfor
                                </x-select-option>
                            </div>
                            {{-- <button type="button"
                        class="rounded-md text-sm p-2.5 font-medium text-center text-white bg-blue-700 ">
                        Add {{ $year }}
                    </button> --}}
                        </div>
                        <x-input-error :messages="$errors->get('year')" class="mt-2" />
                    </div>
                    {{-- End Year Select --}}

                    <div class="">
                        <x-input-label for="language" :value="__('messages.language')" />
                        <x-select-option wire:model='language' class="block w-full mt-1" id="language"
                            name='langauge'>
                            <option value="khmer">{{ __('messages.khmer') }}</option>
                            <option value="english">{{ __('messages.english') }}</option>
                        </x-select-option>
                        <x-input-error :messages="$errors->get('language')" class="mt-2" />
                    </div>
                    <div class="">
                        <x-input-label for="edition" :value="__('messages.edition')" />
                        <x-text-input wire:model='edition' id="edition" class="block w-full mt-1" type="text"
                            name="edition" placeholder='Example: Second Edition' :value="old('edition')"
                            autocomplete="edition" />
                        <x-input-error :messages="$errors->get('edition')" class="mt-2" />
                    </div>



                    <div class="grid gap-4 md:col-span-2 md:grid-cols-2">
                        {{-- Start Category Select --}}
                        <div class="relative w-full mb-5 group">
                            <x-input-label for="category_id" :value="__('Category')" />
                            <div class="flex flex-1 gap-1 mt-1">
                                <div class="flex justify-start flex-1">
                                    <x-select-option wire:model.live='category_id' id="category_id"
                                        name="category_id" class="category-select">
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
                        <div class="relative w-full mb-5 group">
                            <x-input-label for="sub_category_id" :value="__('Sub-Category')" />
                            <div class="flex flex-1 gap-1 mt-1">
                                <div class="flex justify-start flex-1">
                                    <x-select-option wire:model.live='sub_category_id' id="sub_category_id"
                                        name="category_id" class="sub-category-select">
                                        <option wire:key='sub-category' value="">
                                            {{ $category_id ? 'Select Sub-Category...' : 'Select Category First' }}
                                        </option>
                                        @forelse ($subCategories as $subCategory)
                                            <option wire:key='{{ $subCategory->id }}'
                                                value="{{ $subCategory->id }}">
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

                    {{-- Start Image Upload --}}
                    <div class="flex items-center mb-5 md:col-span-2 space-4" wire:key='uploadimage'>
                        @if ($image)
                            <div class="pt-5 max-w-40">
                                <img src="{{ $image->temporaryUrl() }}" alt="Selected Image"
                                    class="max-w-full pr-4 max-h-40" />
                            </div>
                        @endif
                        <div class="flex flex-col flex-1">
                            <label class='mb-4 text-sm font-medium text-gray-600 dark:text-white'>
                                Upload Cover (Max: 2MB)
                            </label>
                            <div class="relative flex items-center justify-center w-full -mt-3 overflow-hidden">
                                <label for="dropzone-file"
                                    class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            PNG, JPG (MAX. 2MB)
                                        </p>

                                    </div>
                                    <input wire:model="image" accept="image/png, image/jpeg, image/gif"
                                        id="dropzone-file" type="file" class="absolute h-[140%] w-[100%]" />
                                </label>
                            </div>
                            <div wire:loading wire:target="image" class="text-blue-700">
                                <span>
                                    <img class="inline w-6 h-6 text-white me-2 animate-spin"
                                        src="{{ asset('assets/images/reload.png') }}" alt="reload-icon">
                                    Uploading...
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>
                    {{-- End Image Upload --}}

                    <div class="flex items-center mb-8 space-4 md:col-span-2" wire:key='uploadfile'
                        x-data="{ uploading: false, progress: 0, paused: false }"
                        x-on:livewire-upload-start="uploading = true; progress = 0; console.log('started');"
                        x-on:livewire-upload-finish="uploading = false; console.log('finished');"
                        x-on:livewire-upload-error="uploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <div class="flex flex-col flex-1">
                            <label class='mb-4 text-sm font-medium text-gray-600 dark:text-white'>
                                Upload File (Max : 50MB)
                            </label>
                            <div class="relative flex items-center justify-center w-full -mt-3 overflow-hidden">
                                <label for="file"
                                    class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">PDF (MAX. 50MB)</p>
                                        @if ($file)
                                            <p class="text-sm text-center text-gray-600 dark:text-gray-400">
                                                <span class="font-bold text-md">Uploaded File :</span>
                                                {{ $file->getClientOriginalName() }}
                                            </p>
                                        @endif
                                    </div>
                                    <input type="file" wire:model="file" id="file" name="file"
                                        accept="application/pdf" class="absolute h-[140%] w-[100%]" />
                                </label>
                            </div>
                            <div wire:loading wire:target="file" class="text-blue-700">
                                <span>
                                    <img class="inline w-6 h-6 text-white me-2 animate-spin"
                                        src="{{ asset('assets/images/reload.png') }}" alt="reload-icon">
                                    Uploading...
                                </span>
                            </div>
                            <style>
                                progress {
                                    border-radius: 3px;
                                }

                                progress::-webkit-progress-bar {
                                    border-radius: 3px;
                                    background-color: rgb(194, 194, 194);
                                }

                                progress::-webkit-progress-value {
                                    border-radius: 3px;
                                    background-color: rgb(17, 150, 17);
                                }
                            </style>
                            <div x-show="uploading" class="flex items-center gap-1">
                                <span x-text="progress + '%'"></span>
                                <progress class="w-full" max="100" x-bind:value="progress"></progress>
                            </div>
                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                        </div>
                    </div>
                    {{-- End file Upload --}}

                </div>
            </section>


            <!-- ISBN Allocation Section -->
            {{-- <section class="mt-8">
                    <h3 class="text-lg font-bold">ISBN Allocated / ISBN attribué</h3>
                    <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-1">
                        <div>
                            <label class="block font-bold">ISBN-13: 978 - 99963 -</label>
                            <input type="text" class="w-full p-2 mt-1 border rounded" placeholder="Enter ISBN">
                        </div>
                        <div>
                            <label class="block font-bold">ISBN-13: 978 - 9924 -</label>
                            <input type="text" class="w-full p-2 mt-1 border rounded" placeholder="Enter ISBN">
                        </div>
                        <div>
                            <label class="block font-bold">ISBN-13: 978 - 9950 -</label>
                            <input type="text" class="w-full p-2 mt-1 border rounded" placeholder="Enter ISBN">
                        </div>
                    </div>
                </section> --}}


        </div>
        <!-- End Name -->


        <div>
            <x-outline-button wire:ignore href="{{ URL::previous() }}">
                Go back
            </x-outline-button>
            <button wire:loading.class="cursor-not-allowed" wire:click.prevent="save" wire:target="save, image, file"
                wire:loading.attr="disabled"
                class = 'text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800'>
                Save
            </button>
            <span wire:target="save" wire:loading>
                <img class="inline w-6 h-6 text-white me-2 animate-spin"
                    src="{{ asset('assets/images/reload.png') }}" alt="reload-icon">
                Saving
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

                $('.year-select').select2();
                $('.year-select').on('change', function(event) {
                    let data = $(this).val();
                    @this.set('year', data);
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
