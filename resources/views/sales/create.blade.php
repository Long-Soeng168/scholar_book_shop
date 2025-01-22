@extends('admin.layouts.admin')

@section('content')
<div class="px-4">
    <x-page-header :value="__('Purchase Create')" />
    @livewire('purchase-create')
</div>

@endsection
