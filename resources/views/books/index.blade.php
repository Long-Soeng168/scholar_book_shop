@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Items')" />
        @livewire('book-table-data')
    </div>
@endsection
