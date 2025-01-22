@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Stocks')" />
        @livewire('stock-table-data')
    </div>
@endsection
