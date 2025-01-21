@extends('admin.layouts.admin')

@section('content')
<x-page-header :value="__('Adjustment Create')" />
<div class="px-4">
    @livewire('adjustment-create')
</div>

@endsection
