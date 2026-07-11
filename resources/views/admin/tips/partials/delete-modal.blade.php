<div class="modal-backdrop hidden" id="deleteTipModal">
    <div class="modal-box">
        <h4>Delete this tip?</h4>
        <p>This will permanently remove the tip and its photo. Farmers who already saved it will keep their own copy. This action cannot be undone.</p>

        <form method="POST" action="" id="deleteTipForm" class="krishi-form">
            @csrf
            @method('delete')

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" id="cancelDeleteTip">Cancel</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>
