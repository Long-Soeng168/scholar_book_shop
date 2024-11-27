@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        <x-form-header :value="__('Edit Contact')" class="p-4" />

        @livewire('contact-edit', [
            'contact' => $contact,
        ])

    </div>
@endsection
