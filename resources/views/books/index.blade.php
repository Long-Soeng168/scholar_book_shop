@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Books')" />
        @livewire('book-table-data')
    </div>
@endsection
