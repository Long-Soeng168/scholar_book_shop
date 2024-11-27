@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Catalog Sub-Categories')" />
        @livewire('book-sub-category-table-data')
    </div>
@endsection
