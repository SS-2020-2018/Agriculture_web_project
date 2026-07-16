@extends('layouts.admin')

@section('title', 'Farmer Management')

@section('header')
    <h2>🧑‍🌾 Farmer Management</h2>
@endsection

@section('content')

    <div class="disease-toolbar">
        <input type="text" id="farmerSearch" class="reminder-search-input" placeholder="🔍 Search by name or email...">

        <div class="reminder-filter-buttons" id="farmerStatusFilter">
            <button type="button" class="filter-btn active" data-status="all">All</button>
            <button type="button" class="filter-btn" data-status="active">Active</button>
            <button type="button" class="filter-btn" data-status="suspended">Suspended</button>
        </div>

        <select id="farmerSortSelect" class="disease-filter-select">
            <option value="recent">Sort: Newest Registered</option>
            <option value="oldest">Sort: Oldest Registered</option>
            <option value="az">Sort: Name (A–Z)</option>
        </select>
    </div>

    @if($farmers->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">🧑‍🌾</div>
            <h3>No farmers registered yet</h3>
        </div>
    @else
        <div class="admin-table-wrap">
            <table class="admin-table" id="farmerTable">
                <thead>
                    <tr>
                        <th>Farmer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>District</th>
                        <th>Registered</th>
                        <th>Crops</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($farmers as $farmer)
                        <tr class="farmer-row"
                            data-title="{{ strtolower($farmer->name.' '.$farmer->email) }}"
                            data-status="{{ $farmer->account_status }}"
                            data-name="{{ strtolower($farmer->name) }}"
                            data-created="{{ $farmer->created_at->timestamp }}">
                            <td>
                                <a href="{{ route('admin.farmers.show', $farmer) }}" class="farmer-name-cell">
                                    @if($farmer->profile && $farmer->profile->photo)
                                        <img src="{{ asset('storage/'.$farmer->profile->photo) }}" alt="{{ $farmer->name }}" class="qa-admin-avatar">
                                    @else
                                        <div class="qa-admin-avatar qa-admin-avatar-placeholder">🧑‍🌾</div>
                                    @endif
                                    <span>{{ $farmer->name }}</span>
                                </a>
                            </td>
                            <td>{{ $farmer->email }}</td>
                            <td>{{ $farmer->profile->phone ?? '—' }}</td>
                            <td>{{ $farmer->profile->district ?? '—' }}</td>
                            <td>{{ $farmer->created_at->format('d M, Y') }}</td>
                            <td>{{ $farmer->crops_count }}</td>
                            <td>
                                <span class="qa-status-badge {{ $farmer->account_status === 'active' ? 'qa-status-answered' : 'qa-status-pending' }}">
                                    {{ ucfirst($farmer->account_status) }}
                                </span>
                            </td>
                            <td class="admin-table-actions">
                                <a href="{{ route('admin.farmers.show', $farmer) }}" class="btn btn-secondary btn-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="empty-state hidden" id="farmerNoMatches">
            <div class="empty-state-icon">🔍</div>
            <h3>No matching farmers</h3>
        </div>
    @endif

@endsection
