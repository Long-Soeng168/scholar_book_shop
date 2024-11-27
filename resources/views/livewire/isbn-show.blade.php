<div>
    <x-outline-button class="m-4" wire:ignore href="{{ URL::previous() }}">
        Go back
    </x-outline-button>
    <div class="max-w-screen-xl px-2 mx-auto mt-4 lg:px-0">

        <div class="min-[800px]:grid grid-cols-12 gap-4">
            <div class="flex flex-col items-center w-full col-span-5 px-2 mb-6 mr-2 lg:col-span-4 lg-px-0">
                <div class="flex flex-col w-full gap-2">
                    <a href="{{ asset('assets/images/isbn/' . $item->image) }}" class="glightbox">
                        <img class="w-full bg-white border rounded-md shadow cursor-pointer"
                            src="{{ asset('assets/images/isbn/' . $item->image) }}" alt="Book Cover">
                    </a>
                    <div class="grid grid-cols-4 gap-2">
                    </div>
                    <!-- Action Button -->
                </div>
            </div>
            <div class="col-span-7 lg:col-span-8">
                <h1 class="block mt-1 mb-2 text-2xl font-medium leading-tight text-gray-800 dark:text-gray-100">
                    {{ $item->title }}
                </h1>
                <div class="flex flex-col gap-2">
                    <div class="flex nowrap">
                        <p
                            class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                            {{ __('messages.authors') }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-200">
                            {{ $item->authors }}
                        </p>
                    </div>
                    <div class="flex nowrap">
                        <p
                            class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                            {{ __('messages.numberOfPages') }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-200">
                            {{ $item->number_of_pages }}
                        </p>
                    </div>
                    <div class="flex nowrap">
                        <p
                            class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                            {{ __('messages.format') }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-200">
                            {{ $item->format }}
                        </p>
                    </div>
                    <div class="flex nowrap">
                        <p
                            class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                            {{ __('messages.price') }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-200">
                            {{ $item->price }}
                        </p>
                    </div>
                    <div class="flex nowrap">
                        <p
                            class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                            {{ __('messages.publicationDate') }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-200">
                            {{ $item->publication_date }}
                        </p>
                    </div>
                    <div class="flex nowrap">
                        <p
                            class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                            {{ __('messages.language') }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-200">
                            {{ $item->language }}
                        </p>
                    </div>
                    <div class="flex nowrap">
                        <p
                            class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                            {{ __('messages.edition') }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-200">
                            {{ $item->edition }}
                        </p>
                    </div>
                    <div class="flex nowrap">
                        <p
                            class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                            {{ __('messages.description') }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-200">
                            {{ $item->description }}
                        </p>
                    </div>
                    <div class="flex nowrap">
                        <p
                            class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                            {{ __('messages.category') }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-200">
                            {{ $item->category?->name }}
                        </p>
                    </div>
                    <div class="flex nowrap">
                        <p
                            class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                            {{ __('messages.subCategory') }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-200">
                            {{ $item->subCategory?->name }}
                        </p>
                    </div>
                    <div class="flex nowrap">
                        <p
                            class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                            {{-- {{ __('messages.publisher') }} --}}
                            {{ __('messages.requestBy') }}
                        </p>
                        @if (request()->user()->hasRole(['admin', 'super-admin']))
                            <a href="{{ url('publisher/' . $item->publisher_id) }}">
                                <p class="text-sm text-blue-600 hover:text-blue-800 hover:underline dark:text-gray-200">
                                    {{ $item->publisher?->name }}
                                </p>
                            </a>
                        @else
                            <p class="text-sm text-gray-600 dark:text-gray-200">
                                {{ $item->publisher?->name }}
                            </p>
                        @endif

                    </div>
                    <div class="flex nowrap">
                        <p
                            class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                            {{ __('messages.createdAt') }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-200">
                            {{ $item->created_at?->format('d-M-Y') }}
                        </p>
                    </div>
                    <div class="flex nowrap">
                        <p
                            class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                            {{ __('messages.isbnLastReceived') }}
                        </p>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-200">
                            {{ $item->isbn_last_received }}
                        </p>
                    </div>
                    <div class="flex nowrap">
                        <p
                            class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                            {{ __('messages.status') }}
                        </p>
                        <p class="text-sm font-semibold text-gray-600 dark:text-gray-200">
                            @if ($item->status == 1)
                                <span class="text-green-700 w-4font-semibold">
                                    Approve
                                </span>
                            @elseif($item->status == 0)
                                <span class="text-yellow-600 w-4font-semibold">
                                    In Review
                                </span>
                            @else
                                <span class="text-red-700 w-4font-semibold">
                                    Reject
                                </span>
                            @endif
                        </p>
                    </div>
                    @if ($item->isbn && $item->status == 1)
                        <div class="flex nowrap">
                            <p
                                class="w-[168px] uppercase tracking-wide text-sm text-gray-500 dark:text-gray-300 font-semibold border-r border-gray-600 dark:border-gray-300 pr-5 mr-5 flex-shrink-0">
                                {{ __('messages.isbn') }}
                            </p>
                            <p class="text-sm font-bold text-gray-600 dark:text-gray-200">
                                {{ $item->isbn }}
                            </p>
                        </div>
                    @endif

                    @if (count($item->comments) > 0)
                        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                            role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                            </svg>
                            <div>
                                <span class="font-medium">Reject Comments:</span>
                                <ul class="mt-1.5">
                                    @forelse ($item->comments as $comment)
                                        <li class="flex items-start mt-2">
                                            <span class="">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 18 18" fill="none" stroke="#991b1b" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-dot">
                                                    <circle cx="12.1" cy="12.1" r="1" />
                                                </svg>
                                            </span>
                                            <span class="inline-flex gap-2">
                                                <span
                                                    class="whitespace-nowrap">{{ $comment->created_at?->format('d-M-Y') }}
                                                    : </span>
                                                <span class="w-auto">{{ $comment->comment }}</span>
                                            </span>
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                    @endif

                    @if (!request()->user()->hasRole(['admin', 'super-admin']) && $item->status !== 1)
                        <a href="{{ url('isbn_requests/' . $item->id . '/edit') }}"
                            class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5   dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-center">
                            Edit and Resubmit
                        </a>
                    @endif

                </div>
            </div>

            @if (request()->user()->hasRole(['admin', 'super-admin']))
                <div class="col-span-12">
                    <div class="flex flex-col max-w-full gap-4 p-4 mx-auto mb-4 border shadow">
                        <div class="">
                            <x-input-label for="isbnAllocated" :value="__('messages.isbnAllocated')" />
                            <x-select-option wire:model.live='isbnAllocated' class="block w-full mt-1"
                                id="isbnAllocated">
                                <option value="">{{ __('messages.select') }}</option>
                                <option value="978-99963-">
                                    978-99963-
                                </option>
                                <option value="978-9924-">
                                    978-9924-
                                </option>
                                <option value="978-9950-">
                                    978-9950-
                                </option>
                            </x-select-option>
                            <x-input-error :messages="$errors->get('isbnAllocated')" class="mt-2" />
                        </div>
                        <div class="">
                            <x-input-label for="giveIsbn" :value="__('messages.giveIsbn')" />
                            <x-text-input wire:key='{{ rand() }}' wire:model='giveIsbn' id="giveIsbn"
                                class="block w-full mt-1" type="text" name="giveIsbn" autocomplete="giveIsbn" />
                            <x-input-error :messages="$errors->get('giveIsbn')" class="mt-2" />
                        </div>
                        <div class="flex">
                            <!-- Modal toggle -->
                            <button data-modal-target="reject-modal" data-modal-toggle="reject-modal"
                                class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800"
                                type="button">
                                Reject
                            </button>

                            <button type="button" wire:click.prevent="approve" wire:target="approve"
                                wire:loading.attr="disabled"
                                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">
                                Approve
                            </button>
                            <span wire:target="approve" wire:loading>
                                <img class="inline w-6 h-6 text-white me-2 animate-spin"
                                    src="{{ asset('assets/images/reload.png') }}" alt="reload-icon">
                                Saving
                            </span>
                        </div>
                    </div>
                </div>
            @else
            @endif


        </div>
    </div>

    {{-- Start Reject Modal --}}
    <div id="reject-modal" wire:ignore tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Reject
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="reject-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="col-span-2">
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Comment
                            </label>
                            <textarea wire:model='reject_comment' id="reject_comment" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Comment, Why This got reject!"></textarea>
                            <x-input-error :messages="['Comment required']" class="mt-2" />
                        </div>
                    </div>
                    <button wire:click.prevent="reject" wire:target="reject" wire:loading.attr="disabled"
                        class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                        Reject
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{-- End Reject Modal --}}


    <footer class="pt-4 mt-10 text-center border-t">
        <p class="text-sm">ISBN National Agency Cambodia c/o National Library of Cambodia</p>
        <p class="text-sm">Ph 92 Christopher Howes, Daun Penh, Phnom Penh, Cambodia. Tel: 023 430 609 - 011
            303 701
        </p>
        <p class="text-sm">Email: monyichhoun99@yahoo.com / 011 303 701 (telegram)</p>
    </footer>

</div>

@script
    <script>
        $(document).ready(function() {
            document.addEventListener('livewire:updated', event => {
                console.log('updated'); // Logs 'Livewire component updated' to browser console
                initFlowbite();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endscript
