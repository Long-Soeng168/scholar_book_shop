@extends('admin.layouts.admin')

@section('content')
    <div class="p-4">
        <x-form-header :value="__('Create Feature')" class="p-4" />

        @livewire('feature-create')

    </div>
@endsection
