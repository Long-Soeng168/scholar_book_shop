@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        <x-form-header :value="__('Edit Promotion')" class="p-4" />

        @livewire('promotion-edit', [
            'id' => $id
        ])

    </div>
@endsection
