@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Products')" />
        @livewire('book-table-data')
    </div>
@endsection
