<div class="modal-backdrop hidden" id="deleteFertilizerModal">
    <div class="modal-box">
        <h4>Delete this fertilizer guide?</h4>
        <p>This action cannot be undone.</p>

        <form method="POST" action="" id="deleteFertilizerForm" class="krishi-form">
            @csrf
            @method('delete')

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" id="cancelDeleteFertilizer">Cancel</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>
