<div class="modal-backdrop hidden" id="deleteDiseaseModal">
    <div class="modal-box">
        <h4>Delete this disease alert?</h4>
        <p>This will permanently remove the record and its photo. This action cannot be undone.</p>

        <form method="POST" action="" id="deleteDiseaseForm" class="krishi-form">
            @csrf
            @method('delete')

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" id="cancelDeleteDisease">Cancel</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>
