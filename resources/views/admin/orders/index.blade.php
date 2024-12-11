@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Orders')" />
        @livewire('order-table-data')
    </div>
@endsection
