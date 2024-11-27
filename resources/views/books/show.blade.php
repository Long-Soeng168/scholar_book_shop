@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    @livewire('book-show', [
        'id' => $id
    ])
</div>

@endsection
