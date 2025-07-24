@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Document #{{ $document->id }}</h1>
    
    <!-- Document Details -->
    <div class="card mb-4">
        <div class="card-header">
            Document Details
        </div>
        <div class="card-body">
            <p><strong>User:</strong> {{ $document->user->name }} {{ $document->user->lastname }}</p>
            <p><strong>Email:</strong> {{ $document->user->email }}</p>
            <p><strong>Phone:</strong> {{ $document->user->phone }}</p>
            <p><strong>Submitted:</strong> {{ $document->created_at->format('Y-m-d H:i') }}</p>
            <p><strong>Notes:</strong> {{ $document->notes ?? 'None' }}</p>
            <p><strong>Current Status:</strong>
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
            </p>
            <a href="{{ asset('storage/'.$document->document_path) }}" class="btn btn-primary" target="_blank">View Document</a>
        </div>
    </div>

    <!-- Principal Investigator Details -->
  

    <div class="card mb-4">
    <div class="card-header">
        Principal Investigator
    </div>
    <div class="card-body">
        <p><strong>Full Name:</strong> {{ $document->principal_investigator['full_name'] ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $document->principal_investigator['email'] ?? 'N/A' }}</p>
        <p><strong>Department:</strong> {{ $document->principal_investigator['department'] ?? 'N/A' }}</p>
    </div>
</div>

    <!-- Co-Investigators Details -->
    <div class="card mb-4">
        <div class="card-header">
            Co-Investigators
        </div>
        <div class="card-body">
            @if($document->coInvestigators->isEmpty())
                <p>No co-investigators added.</p>
            @else
                <ul class="list-group">
                    @foreach($document->coInvestigators as $coInvestigator)
                        <li class="list-group-item">
                            <p><strong>Full Name:</strong> {{ $coInvestigator->full_name }}</p>
                            <p><strong>Email:</strong> {{ $coInvestigator->email }}</p>
                            <p><strong>Specialization:</strong> {{ $coInvestigator->specialization }}</p>
                            <p><strong>Phone:</strong> {{ $coInvestigator->phone }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <!-- Update Status -->
    <div class="card mb-4">
        <div class="card-header">
            Update Status
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.documents.updateStatus', $document) }}">
                @csrf
                <div class="mb-3">
                    <label for="status" class="form-label">New Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="received" {{ $status == 'received' ? 'selected' : '' }}>Received</option>
                        <option value="in_progress" {{ $status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="in_transaction" {{ $status == 'in_transaction' ? 'selected' : '' }}>In Transaction</option>
                        <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="canceled" {{ $status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message (Optional)</label>
                    <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>

    <!-- Send for Review -->
  <div class="card mb-4">
    <div class="card-header">
        Send for Review
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.documents.sendForReview', $document) }}">
            @csrf
            <div class="mb-3">
                <label for="reviewer_id" class="form-label">Select Reviewer</label>
                <select class="form-select" id="reviewer_id" name="reviewer_id[]" multiple required>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
        </select>
        <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple reviewers.</small>

            </div>
            <button type="submit" class="btn btn-success">Send for Review</button>
        </form>
    </div>
</div>

    <!-- Status History -->
    <h3>Status History</h3>
    <div class="list-group">
        @foreach($statuses as $status)
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">
                        {{ str_replace('_', ' ', ucfirst($status->status)) }}
                    </h5>
                    <small>{{ $status->created_at->format('Y-m-d H:i') }}</small>
                </div>
                <p class="mb-1">{{ $status->message }}</p>
                <small>Updated by: {{ $status->admin->name }}</small>
            </div>
        @endforeach
    </div>
</div>
@endsection