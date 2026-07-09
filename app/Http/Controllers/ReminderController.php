<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReminderRequest;
use App\Http\Requests\UpdateReminderRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ReminderController extends Controller
{
    /*
     Display the Reminder Management page: sidebar form + the farmer's
     full reminder list (chronological), plus summary stats.
     */
    public function index(Request $request): View
    {
        $farmer = $request->user();

        $reminders = Task::where('user_id', $farmer->id)
            ->orderBy('reminder_date')
            ->orderBy('created_at')
            ->get();

        return view('reminders.index', [
            'reminders' => $reminders,
            'stats' => $this->buildStats($farmer->id),
        ]);
    }

    /*
     Store a newly created reminder for the authenticated farmer.
     */
    public function store(StoreReminderRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;

        Task::create($validated);

        return redirect()->route('reminders.index')->with('status', 'reminder-added');
    }

    /*
     Update an existing reminder's title, date, or notes.
     (Completion status is handled separately by toggle() below.)
     */
    public function update(UpdateReminderRequest $request, Task $reminder): RedirectResponse
    {
        Gate::authorize('update', $reminder);

        $reminder->update($request->validated());

        return redirect()->route('reminders.index')->with('status', 'reminder-updated');
    }

    /*
     Flip a reminder's completed/pending status. Called via fetch() from
     the checkbox in the reminder list, so the UI updates instantly
     without a full page reload. Returns the new status plus refreshed
     summary counts so the frontend can update the stat boxes too.
     */
    public function toggle(Request $request, Task $reminder): JsonResponse
    {
        Gate::authorize('update', $reminder);

        $reminder->is_completed = ! $reminder->is_completed;
        $reminder->save();

        return response()->json([
            'is_completed' => $reminder->is_completed,
            'stats' => $this->buildStats($reminder->user_id),
        ]);
    }

    /*
     Permanently delete a reminder.
     */
    public function destroy(Task $reminder): RedirectResponse
    {
        Gate::authorize('delete', $reminder);

        $reminder->delete();

        return redirect()->route('reminders.index')->with('status', 'reminder-deleted');
    }

    /*
     Shared summary-stat calculation used by both index() (page load)
     and toggle() (AJAX response), so the two never drift out of sync.
     @return array{total: int, pending: int, completed: int, today: int}
     */
    private function buildStats(int $userId): array
    {
        $tasks = Task::where('user_id', $userId)->get();

        return [
            'total' => $tasks->count(),
            'pending' => $tasks->where('is_completed', false)->count(),
            'completed' => $tasks->where('is_completed', true)->count(),
            'today' => $tasks->filter(fn (Task $task) => $task->reminder_date->isToday())->count(),
        ];
    }
}
