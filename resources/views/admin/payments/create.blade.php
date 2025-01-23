@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        <x-form-header :value="__('Create Payment')" class="p-4" />

        @livewire('payment-create')

    </div>
@endsection
