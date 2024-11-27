@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('ISBN Request History')" />
        @livewire('isbn-table-data')
    </div>
@endsection
