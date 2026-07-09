{{-- Delete confirmation modal for reminders. Any button with
     [data-open-delete-modal] and a [data-delete-url] attribute opens this
     modal and points the delete form at that reminder's URL — see the
     "Reminder delete confirmation" block in app-phase5-additions.js. --}}
<div class="modal-backdrop hidden" id="deleteReminderModal">
    <div class="modal-box">
        <h4>Delete this reminder?</h4>
        <p>This action cannot be undone.</p>

        <form method="POST" action="" id="deleteReminderForm" class="krishi-form">
            @csrf
            @method('delete')

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" id="cancelDeleteReminder">Cancel</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </form>
    </div>
</div>
