@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Promotions')" />
        @livewire('promotion-table-data')
    </div>
@endsection
