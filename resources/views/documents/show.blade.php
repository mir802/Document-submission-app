@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Document #{{ $document->id }}</h1>
    
    <!-- Document Details -->
    <div class="card mb-4">
        <div class="card-header">
            Document Details
        </div>
        <div class="card-body">
            <!-- Title -->
            <p><strong>Title:</strong> {{ $document->title }}</p>

            <!-- Principal Investigator -->
            <h5 class="mt-3">Principal Investigator</h5>
            <p><strong>Full Name:</strong> {{ $document->principal_investigator['full_name'] }}</p>
            <p><strong>Email:</strong> {{ $document->principal_investigator['email'] }}</p>
            <p><strong>Department:</strong> {{ $document->principal_investigator['department'] }}</p>

            <!-- Co-Investigators -->
            <h5 class="mt-4">Co-Investigators</h5>
            @if($document->coInvestigators->count() > 0)
                <ul class="list-group mb-3">
                    @foreach($document->coInvestigators as $coInvestigator)
                        <li class="list-group-item">
                            <p><strong>Full Name:</strong> {{ $coInvestigator->full_name }}</p>
                            <p><strong>Email:</strong> {{ $coInvestigator->email }}</p>
                            <p><strong>Specialization:</strong> {{ $coInvestigator->specialization }}</p>
                            <p><strong>Phone:</strong> {{ $coInvestigator->phone }}</p>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No co-investigators specified.</p>
            @endif

            <!-- CVs -->
            <h5 class="mt-4">CV(s)</h5>
            <ul class="list-group mb-3">
                @foreach($document->cv_paths as $cv)
                    <li class="list-group-item">
                        <a href="{{ asset('storage/'.$cv) }}" target="_blank" class="btn btn-link">View CV</a>
                    </li>
                @endforeach
            </ul>

            <!-- Submission Details -->
            <p><strong>Submitted On:</strong> {{ $document->created_at->format('Y-m-d H:i') }}</p>
            <p><strong>Notes:</strong> {{ $document->notes ?? 'None' }}</p>

            <!-- Current Status -->
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

            <!-- View Document -->
            <a href="{{ asset('storage/'.$document->document_path) }}" class="btn btn-primary" target="_blank">View Document</a>

            <!-- Edit Button -->
            <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-secondary">Edit Document</a>
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