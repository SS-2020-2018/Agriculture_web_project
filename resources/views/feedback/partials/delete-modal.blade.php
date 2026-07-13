<div class="modal-backdrop hidden" id="deleteFeedbackModal">
    <div class="modal-box">
        <h4>Delete this feedback?</h4>
        <p>This action cannot be undone.</p>

        <form method="POST" action="" id="deleteFeedbackForm" class="krishi-form">
            @csrf
            @method('delete')

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" id="cancelDeleteFeedback">Cancel</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>
