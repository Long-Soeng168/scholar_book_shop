@extends('admin.layouts.admin')

@section('content')
<div class="p-4">
    @livewire('book-edit', [
        'id' => $id
    ])
</div>

@endsection
