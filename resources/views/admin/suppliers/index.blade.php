@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Suppliers')" />
        @livewire('supplier-table-data')
    </div>
@endsection
