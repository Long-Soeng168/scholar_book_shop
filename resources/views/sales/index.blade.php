@extends('admin.layouts.admin')
@section('content')
    <div>
        {{-- <x-page-header :value="__('Purchases')" /> --}}
        @livewire('sale-table-data')
    </div>
@endsection
