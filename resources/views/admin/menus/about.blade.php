@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        <x-form-header :value="__('Edit About')" class="p-4" />

        @livewire('about-edit', [
            'about' => $about,
        ])

    </div>
@endsection
