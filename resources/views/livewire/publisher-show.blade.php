<div class="bg-white dark:bg-gray-700 dark:text-gray-50">
    <!-- Profile Banner -->
    <div class="relative w-full aspect-[21/6] bg-gray-300 dark:bg-gray-700">
        {{-- <img src="https://via.placeholder.com/1000x250" alt="Banner" class="object-cover w-full h-full"> --}}
        @if ($user->banner)
        <img src="{{ asset('assets/images/users/banners/thumb/'.$user->banner) }}" alt="Banner" class="object-cover w-full h-full">
        @else
        <img src="https://via.placeholder.com/1000x250" alt="Banner" class="object-cover w-full h-full">
        @endif

    </div>

    <!-- Profile Details Section -->
    <div class="w-full mx-auto mt-4 rounded-lg shadow-md">
        <div class="flex">
            <img src="{{ asset('assets/images/users/thumb/'.($user->image ? $user->image : 'user.png')) }}" alt="Logo"
                class="object-cover w-32 h-32 p-0.5 m-4 bg-gray-100 border-4 border-white rounded-full"
            >

            <div class="py-4 text-gray-600 dark:text-gray-50">
                <h1 class="text-2xl font-bold ">
                    {{ $user->name }}
                </h1>
                <div class="flex flex-col items-start justify-start mt-4">
                    <div class="flex items-start justify-start gap-2 ">
                        <strong>{{ __('messages.phone') }}:</strong>
                        <p class="text-start ">
                            {{ $user->phone }}
                        </p>
                    </div>
                    <div class="flex items-start justify-start gap-2">
                        <strong>{{ __('messages.email') }}:</strong>
                        <p class="text-start ">
                            {{ $user->email }}
                        </p>
                    </div>
                    <div class="flex items-start justify-start gap-2">
                        <strong>{{ __('messages.facebookName') }}:</strong>
                        <p class="text-start ">
                            {{ $user->facebook_name }}
                        </p>
                    </div>
                    <div class="flex items-start justify-start gap-2">
                        <strong>{{ __('messages.publicationsEachYear') }}:</strong>
                        <p class="uppercase text-start">
                            {{ $user->publications_each_year }}
                        </p>
                    </div>
                    <div class="flex justify-start gap-2">
                        <strong>{{ __('messages.location') }}:</strong>
                        <p class="text-start ">
                            {{ $user->address }}
                        </p>
                    </div>


                </div>
            </div>

        </div>
        {{-- Start ISBN --}}
        <div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">No</th>
                            <th scope="col" class="px-4 py-3">Image</th>
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
                            <th scope="col" class="px-4 py-3">Publisher</th>
                            <th scope="col" class="px-4 py-3">ISBN</th>
                            <th scope="col" class="px-4 py-3 text-center">Status</th>
                            <th scope="col" class="px-4 py-3">Created_at</th>
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
                                    <a href="{{ asset('assets/images/isbn/' . $item->image) }}" class="glightbox">
                                        <img src="{{ asset('assets/images/isbn/thumb/' . $item->image) }}"
                                            alt="iMac Front Image" class="object-contain h-10 mr-3 aspect-[16/9]">
                                    </a>
                                </th>
                                <x-table-data value="{{ $item->title }}" />
                                <x-table-data value="{{ $item->publisher?->name }}" />
                                <x-table-data value="{{ $item->status == 1 ? $item->isbn : 'N/A' }}" />
                                <td class="text-center">
                                    @if ($item->status == 1)
                                        <span class="w-4 px-4 py-3 font-semibold text-green-700">
                                            Approve
                                        </span>
                                    @elseif($item->status == 0)
                                        <span class="w-4 px-4 py-3 font-semibold text-yellow-600">
                                            In Review
                                        </span>
                                    @else
                                        <span class="w-4 px-4 py-3 font-semibold text-red-700">
                                            Reject
                                        </span>
                                    @endif
                                </td>

                                <x-table-data value="{{ $item->created_at?->format('d-M-Y') }}" />


                                <td class="px-6 py-4">
                                    <div class="flex items-start justify-end gap-3">

                                        <div class="pb-1" x-data="{ tooltip: false }">
                                            <!-- Modal toggle -->
                                            <a href="{{ url('/isbn_requests/' . $item->id) }}"
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
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white whitespace-nowrap">Record
                            per
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
    </div>



</div>
