@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    <x-page-header :value="__('Sale Edit')" />
    @livewire('sale-edit', [
        'id' => $id
    ])
</div>

@endsection
