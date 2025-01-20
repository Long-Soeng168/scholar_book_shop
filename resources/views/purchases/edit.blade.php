@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    <x-page-header :value="__('Purchase Edit')" />
    @livewire('purchase-edit', [
        'id' => $id
    ])
</div>

@endsection
