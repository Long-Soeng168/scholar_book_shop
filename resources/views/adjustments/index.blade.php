@extends('admin.layouts.admin')
@section('content')
    <div>
        {{-- <x-page-header :value="__('Purchases')" /> --}}
        @livewire('adjustment-table-data')
    </div>
@endsection
