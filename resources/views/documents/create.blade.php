@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Submit Thesis</h1>
    <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title of the Thesis</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter the thesis title" required>
        </div>

        <!-- Principal Investigator Details -->
        <h3>Principal Investigator</h3>
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="principal_investigator[full_name]" placeholder="Enter full name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="principal_investigator[email]" placeholder="Enter email" required>
        </div>

        <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <input type="text" class="form-control" id="department" name="principal_investigator[department]" placeholder="Enter department" required>
        </div>

        <!-- Number of Investigators -->
        <div class="mb-3">
            <label for="number_of_investigators" class="form-label">Number of Investigators</label>
            <input type="number" class="form-control" id="number_of_investigators" name="number_of_investigators" placeholder="Enter number of investigators" min="1" required>
        </div>

        <!-- Co-Investigators -->
        <h3>Co-Investigators</h3>
        <div id="coInvestigatorsWrapper"></div> <!-- Dynamic fields will be appended here -->

        <!-- Add Co-Investigator Button -->
        <div class="mb-3">
            <button type="button" id="addCoInvestigator" class="btn btn-success">Add Co-Investigator</button>
        </div>

        <!-- CV Upload -->
        <div class="mb-3">
            <label for="cv" class="form-label">CV (PDF)</label>
            <input type="file" class="form-control" id="cv" name="cv[]" accept=".pdf" multiple required>
        </div>

        <!-- Document Upload -->
        <div class="mb-3">
            <label for="document" class="form-label">Document (PDF, DOC, DOCX, JPG, PNG)</label>
            <input type="file" class="form-control" id="document" name="document" required>
        </div>

        <!-- Notes -->
        <div class="mb-3">
            <label for="notes" class="form-label">Notes (Optional)</label>
            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('documents.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- JavaScript for Dynamic Fields -->
<script>
    let coInvestigatorIndex = 0;

    document.getElementById('addCoInvestigator').addEventListener('click', function() {
        coInvestigatorIndex++;

        const coInvestigatorTemplate = `
            <div class="card mb-3 p-3 border border-dark">
                <h5>Co-Investigator ${coInvestigatorIndex}</h5>
                <div class="mb-3">
                    <label for="co_investigators[${coInvestigatorIndex}][full_name]" class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="co_investigators[${coInvestigatorIndex}][full_name]" placeholder="Enter full name" required>
                </div>
                <div class="mb-3">
                    <label for="co_investigators[${coInvestigatorIndex}][email]" class="form-label">Email</label>
                    <input type="email" class="form-control" name="co_investigators[${coInvestigatorIndex}][email]" placeholder="Enter email" required>
                </div>
                <div class="mb-3">
                    <label for="co_investigators[${coInvestigatorIndex}][specialization]" class="form-label">Specialization</label>
                    <input type="text" class="form-control" name="co_investigators[${coInvestigatorIndex}][specialization]" placeholder="Enter specialization" required>
                </div>
                <div class="mb-3">
                    <label for="co_investigators[${coInvestigatorIndex}][phone]" class="form-label">Phone</label>
                    <input type="text" class="form-control" name="co_investigators[${coInvestigatorIndex}][phone]" placeholder="Enter phone number" required>
                </div>
                <button type="button" class="btn btn-danger removeCoInvestigator">Remove</button>
            </div>
        `;

        document.getElementById('coInvestigatorsWrapper').insertAdjacentHTML('beforeend', coInvestigatorTemplate);

        // Add event listener for "Remove" button
        document.querySelectorAll('.removeCoInvestigator').forEach(button => {
            button.addEventListener('click', function() {
                this.parentElement.remove();
            });
        });
    });
</script>
@endsection