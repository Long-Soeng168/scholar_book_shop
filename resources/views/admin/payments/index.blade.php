@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Payment Methods')" />
        @livewire('payment-table-data')
    </div>
@endsection
