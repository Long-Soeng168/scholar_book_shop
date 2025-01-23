@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        <x-form-header :value="__('Edit Payment')" class="p-4" />

        @livewire('payment-edit', [
            'item' => $item,
        ])

    </div>
@endsection
