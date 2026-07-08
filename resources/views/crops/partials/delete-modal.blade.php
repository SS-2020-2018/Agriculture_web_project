{{-- Shared delete confirmation modal. Any button with [data-open-delete-modal]
     and a [data-delete-url] attribute will open this modal and point the
     delete form at that URL — see the "Crop delete confirmation" block
     in app-phase4-additions.js. --}}
<div class="modal-backdrop hidden" id="deleteCropModal">
    <div class="modal-box">
        <h4>Delete this crop?</h4>
        <p>This will permanently remove the crop record and its photo. This action cannot be undone.</p>

        <form method="POST" action="" id="deleteCropForm" class="krishi-form">
            @csrf
            @method('delete')

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" id="cancelDeleteCrop">Cancel</button>
                <button type="submit" class="btn btn-danger">Yes, Delete Crop</button>
            </div>
        </form>
    </div>
</div>
