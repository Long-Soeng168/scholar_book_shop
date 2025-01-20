@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Purchases')" />
        @livewire('purchase-table-data')
    </div>
@endsection
