<div class="modal-backdrop hidden" id="deleteNewsModal">
    <div class="modal-box">
        <h4>Delete this article?</h4>
        <p>This will permanently remove the article and its photo. This action cannot be undone.</p>

        <form method="POST" action="" id="deleteNewsForm" class="krishi-form">
            @csrf
            @method('delete')

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" id="cancelDeleteNews">Cancel</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>
