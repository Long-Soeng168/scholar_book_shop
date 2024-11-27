@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        <x-form-header :value="__('Edit Feature')" class="p-4" />

        @livewire('feature-edit', [
            'item' => $item,
        ])

    </div>
@endsection
