@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        <x-form-header :value="__('Create Promotion')" class="p-4" />

        @livewire('promotion-create')

    </div>
@endsection
