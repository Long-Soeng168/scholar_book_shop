@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Orders')" />
        @livewire('order-show', ['id' => $id])
    </div>
@endsection
