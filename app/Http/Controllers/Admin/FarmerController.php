<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Crop;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FarmerController extends Controller
{
    /**
     * List every farmer account. Search/filter/sort happen client-side
     * in JS, consistent with the rest of the admin area.
     */
    public function index(): View
    {
        $farmers = User::where('role', 'farmer')
            ->with('profile')
            ->withCount('crops')
            ->latest()
            ->get();

        return view('admin.farmers.index', compact('farmers'));
    }

    /**
     * Full profile page for one farmer: personal info + every crop
     * they've registered, with an inline feedback form on each crop.
     * This is also where the admin_feedback field on crops (left as a
     * TODO all the way back in Phase 4) finally gets a UI.
     */
    public function show(User $farmer): View
    {
        abort_unless($farmer->role === 'farmer', 404);

        $farmer->load('profile');
        $crops = Crop::where('user_id', $farmer->id)->latest()->get();

        return view('admin.farmers.show', compact('farmer', 'crops'));
    }

    /**
     * Suspend or reactivate a farmer's account. Suspended accounts are
     * blocked at login — see LoginRequest::authenticate().
     */
    public function toggleStatus(User $farmer): RedirectResponse
    {
        abort_unless($farmer->role === 'farmer', 404);

        $farmer->account_status = $farmer->isSuspended() ? 'active' : 'suspended';
        $farmer->save();

        return back()->with('status', $farmer->isSuspended() ? 'farmer-suspended' : 'farmer-reactivated');
    }

    /**
     * Leave (or update) admin feedback on a specific crop. Per the
     * spec, admins can give feedback but never edit/delete a farmer's
     * crop record directly — this is the only write access admins have
     * to the crops table.
     */
    public function giveCropFeedback(Request $request, Crop $crop): RedirectResponse
    {
        $validated = $request->validate([
            'admin_feedback' => ['required', 'string', 'max:1000'],
        ]);

        $crop->admin_feedback = $validated['admin_feedback'];
        $crop->admin_feedback_at = now();
        $crop->save();

        return back()->with('status', 'crop-feedback-saved');
    }
}
