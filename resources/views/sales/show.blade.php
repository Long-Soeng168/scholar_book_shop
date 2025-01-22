@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    @livewire('sale-show', [
        'id' => $id
    ])
</div>

@endsection
