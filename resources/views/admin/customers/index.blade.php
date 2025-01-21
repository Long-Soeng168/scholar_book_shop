@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Customers')" />
        @livewire('customer-table-data')
    </div>
@endsection
