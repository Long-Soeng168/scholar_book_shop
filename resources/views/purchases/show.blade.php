@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    @livewire('purchase-show', [
        'id' => $id
    ])
</div>

@endsection
