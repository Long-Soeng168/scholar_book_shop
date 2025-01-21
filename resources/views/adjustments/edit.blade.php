@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    <x-page-header :value="__('Adjustment Edit')" />
    @livewire('adjustment-edit', [
        'id' => $id
    ])
</div>

@endsection
