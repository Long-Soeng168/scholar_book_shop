@extends('admin.layouts.admin')
@section('content')
    <div>
        <x-page-header :value="__('Features')" />
        @livewire('feature-table-data')
    </div>
@endsection
