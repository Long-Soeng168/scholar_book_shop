<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Expired</title>
    <script src="{{ asset('assets/js/tailwind34.js') }}"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="flex flex-col items-center p-8 bg-white rounded-lg shadow-lg">
        <img src="{{ asset('assets/icons/in_review.png') }}" class="h-20 aspect-square" alt="">
        <h1 class="my-4 text-2xl font-bold text-yellow-600 max-w-[45ch] text-center">
            @if (request()->user()?->status == 1)
                <span class="w-4 py-3 font-semibold text-green-700">
                    Your Account has been Approved.
                </span>
            @elseif(request()->user()?->status == 0)
                <span class="w-4 py-3 font-semibold text-yellow-600">
                    Your account is currently under review. You will receive an email notification once your account has been approved.
                </span>
            @else
                <span class="w-4 py-3 font-semibold text-red-700">
                    Your Account has been Rejected.
                </span>
            @endif
        </h1>
        <p class="text-gray-700">
            @if (request()->user()?->status == 1)
                <a href="{{ url('admin/dashboard') }}" class="w-4 py-3 font-semibold text-blue-700 underline">
                    Go To Dashboard
                </a>
            @else
                <span class="w-4 py-3 font-semibold text-red-700">
                    Please contact admin for more information.
                </span>
            @endif

        </p>
        @if (request()->user()?->status !== 1)

            <div class="mt-8">
                <h2 class="mb-3 text-sm font-semibold uppercase dark:text-white lg:text-center">

                    {{ app()->getLocale() == 'kh' ? 'តំណភ្ជាប់សង្គម' : 'Social Links' }}
                </h2>

                <div class="flex flex-wrap gap-2 mt-4 mb-4 lg:justify-center sm:mt-0">
                    @forelse ($links as $item)
                        <a target="_blank" href="{{ $item->link }}" class="hover:text-gray-900 dark:hover:text-white">
                            <img class="h-[55px] aspect-square object-contain rounded-full border border-white hover:scale-110 transition-all"
                                src="{{ asset('assets/images/links/' . $item->image) }}" alt="Facebook page" />
                            <span class="sr-only">{{ $item->name }}</span>
                        </a>
                    @empty
                    @endforelse
                </div>
            </div>
        @endif

    </div>
</body>

</html>
