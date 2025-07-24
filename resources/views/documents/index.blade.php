@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Documents</h1>
    <a href="{{ route('documents.create') }}" class="btn btn-primary mb-3">Submit New Document</a>
    
    @if($documents->isEmpty())
        <div class="alert alert-info">You haven't submitted any documents yet.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Submitted At</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                        <tr>
                            <td>{{ $document->id }}</td>
                            <td>{{ $document->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                @php
                                    $status = $document->currentStatus->status ?? 'unknown';
                                    $badgeClass = [
                                        'received' => 'bg-primary',
                                        'in_progress' => 'bg-info',
                                        'in_transaction' => 'bg-warning',
                                        'completed' => 'bg-success',
                                        'canceled' => 'bg-danger',
                                    ][$status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ str_replace('_', ' ', ucfirst($status)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('documents.show', $document) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection