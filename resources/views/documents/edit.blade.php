@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Thesis</h1>
    <form method="POST" action="{{ route('documents.update', $document->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title of the Thesis</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $document->title) }}" required>
        </div>

        <!-- Principal Investigator Details -->
        <h3>Principal Investigator</h3>
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="principal_investigator[full_name]" value="{{ old('principal_investigator.full_name', $document->principal_investigator['full_name']) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="principal_investigator[email]" value="{{ old('principal_investigator.email', $document->principal_investigator['email']) }}" required>
        </div>

        <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <input type="text" class="form-control" id="department" name="principal_investigator[department]" value="{{ old('principal_investigator.department', $document->principal_investigator['department']) }}" required>
        </div>

        <!-- Number of Investigators -->
        <div class="mb-3">
            <label for="number_of_investigators" class="form-label">Number of Investigators</label>
            <input type="number" class="form-control" id="number_of_investigators" name="number_of_investigators" value="{{ old('number_of_investigators', $document->number_of_investigators) }}" min="1" required>
        </div>

        <!-- Co-Investigators -->
        <h3>Co-Investigators</h3>
        <div id="coInvestigatorsWrapper">
            @foreach ($document->coInvestigators as $index => $coInvestigator)
                <div class="card mb-3 p-3 border border-dark">
                    <h5>Co-Investigator {{ $index + 1 }}</h5>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="co_investigators[{{ $index }}][full_name]" value="{{ old("co_investigators.$index.full_name", $coInvestigator->full_name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="co_investigators[{{ $index }}][email]" value="{{ old("co_investigators.$index.email", $coInvestigator->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Specialization</label>
                        <input type="text" class="form-control" name="co_investigators[{{ $index }}][specialization]" value="{{ old("co_investigators.$index.specialization", $coInvestigator->specialization) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="co_investigators[{{ $index }}][phone]" value="{{ old("co_investigators.$index.phone", $coInvestigator->phone) }}" required>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- CV Upload -->
        <div class="mb-3">
            <label for="cv" class="form-label">CV (PDF)</label>
            <input type="file" class="form-control" id="cv" name="cv[]" accept=".pdf" multiple>
        </div>

        <!-- Document Upload -->
        <div class="mb-3">
            <label for="document" class="form-label">Document (PDF, DOC, DOCX, JPG, PNG)</label>
            <input type="file" class="form-control" id="document" name="document">
        </div>

        <!-- Notes -->
        <div class="mb-3">
            <label for="notes" class="form-label">Notes (Optional)</label>
            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $document->notes) }}</textarea>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('documents.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection