@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Panel - Document Submissions</h1>
    
    @if($documents->isEmpty())
        <div class="alert alert-info">No documents have been submitted yet.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Submitted At</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                        <tr>
                            <td>{{ $document->id }}</td>
                            <td>{{ $document->user->name }} {{ $document->user->lastname }}</td>
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
                                <a href="{{ route('admin.documents.show', $document) }}" class="btn btn-sm btn-info">Manage</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <h3>All Users</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Admin Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach(\App\Models\User::all() as $user)
            <tr>
                <td>{{ $user->name }} {{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
              <td>
            <span class="badge 
                {{ $user->is_admin ? 'bg-success' : ($user->is_reviewer ? 'bg-warning' : 'bg-secondary') }}">
                {{ $user->is_admin ? 'Admin' : ($user->is_reviewer ? 'Reviewer' : 'User') }}
            </span>
        </td>
                <td>
                  @if(auth()->user()->is_admin && $user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.toggleAdmin', $user) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $user->is_reviewer ? 'btn-danger' : 'btn-success' }}">
                                {{ $user->is_reviewer ? 'Remove Reviewer' : 'Make Reviewer' }}
                            </button>
                        </form>
                    @elseif($user->id === auth()->id())
                        <em>You</em>
                    @else
                        <em>Restricted</em>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
    @endif
</div>
@endsection