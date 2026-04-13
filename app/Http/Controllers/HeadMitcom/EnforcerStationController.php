<?php

namespace App\Http\Controllers\HeadMitcom;

use App\Http\Controllers\Controller;
use App\Models\EnforcerStation;
use App\Models\User;
use Illuminate\Http\Request;

class EnforcerStationController extends Controller
{
    public function index(Request $request)
    {
        $query = EnforcerStation::with('enforcer');
        // Search by label or enforcer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('label', 'like', "%{$search}%")
                ->orWhereHas('enforcer', function ($q2) use ($search) {
                    $q2->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                });
            });
        }
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)->where('expires_at', '>=', today());
            } elseif ($request->status === 'expired') {
                $query->where('expires_at', '<', today());
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false)->where('expires_at', '>=', today());
            }
        }

        // Filter by enforcer
        if ($request->filled('enforcer_id')) {
            $query->where('enforcer_id', $request->enforcer_id);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        match($sort) {
            'oldest'     => $query->orderBy('assigned_at'),
            'expires'    => $query->orderBy('expires_at'),
            'enforcer'   => $query->join('users', 'users.id', '=', 'enforcer_stations.enforcer_id')
                                ->orderBy('users.first_name')
                                ->select('enforcer_stations.*'),
            default      => $query->orderByDesc('assigned_at'),
        };

        $stations = $query->paginate(10)->withQueryString();

        $activeCount = EnforcerStation::where('is_active', true)
            ->where('expires_at', '>=', today())
            ->count();

        $expiredCount = EnforcerStation::where('expires_at', '<', today())->count();

        $enforcers = User::where('role', 'enforcer')->orderBy('first_name')->get();

        return view('head-mitcom.enforcer-stations.index', compact(
            'stations', 'activeCount', 'expiredCount', 'enforcers'
        ));
    }
    public function show(EnforcerStation $enforcerStation)
    {
        $enforcerStation->load('enforcer');

        $history = EnforcerStation::where('enforcer_id', $enforcerStation->enforcer_id)
            ->where('id', '!=', $enforcerStation->id)
            ->orderByDesc('assigned_at')
            ->get();

        return view('head-mitcom.enforcer-stations.show', compact('enforcerStation', 'history'));
    }
   public function create()
    {
        $enforcers = User::where('role', 'enforcer')->orderBy('first_name')->get();
        $selectedEnforcerId = request('enforcer_id');

        return view('head-mitcom.enforcer-stations.create', compact('enforcers', 'selectedEnforcerId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'enforcer_id'  => 'required|exists:users,id',
            'label'        => 'required|string|max:255',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
            'assigned_at'  => 'required|date',
            'expires_at'   => 'required|date|after:assigned_at',
            'notes'        => 'nullable|string',
        ]);

        // Deactivate any existing active station for this enforcer
        EnforcerStation::where('enforcer_id', $request->enforcer_id)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        EnforcerStation::create([
            'enforcer_id' => $request->enforcer_id,
            'label'       => $request->label,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'assigned_at' => $request->assigned_at,
            'expires_at'  => $request->expires_at,
            'notes'       => $request->notes,
            'is_active'   => true,
        ]);

        return redirect()->route('head-mitcom.enforcer-stations.index')
            ->with('success', 'Station assignment saved.');
    }

    public function edit(EnforcerStation $enforcerStation)
        {
            $enforcers = User::where('role', 'enforcer')->orderBy('first_name')->get();

            return view('head-mitcom.enforcer-stations.edit', compact('enforcerStation', 'enforcers'));
        }

    public function update(Request $request, EnforcerStation $enforcerStation)
    {
        $request->validate([
            'enforcer_id'  => 'required|exists:users,id',
            'label'        => 'required|string|max:255',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
            'assigned_at'  => 'required|date',
            'expires_at'   => 'required|date|after:assigned_at',
            'notes'        => 'nullable|string',
        ]);

        // If enforcer changed, deactivate old enforcer's station
        if ($request->enforcer_id != $enforcerStation->enforcer_id) {
            EnforcerStation::where('enforcer_id', $request->enforcer_id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $enforcerStation->update($request->only([
            'enforcer_id', 'label', 'latitude', 'longitude',
            'assigned_at', 'expires_at', 'notes', 'is_active',
        ]));

        return redirect()->route('head-mitcom.enforcer-stations.index')
            ->with('success', 'Station assignment updated.');
    }

    public function destroy(EnforcerStation $enforcerStation)
    {
        $enforcerStation->delete();

        return redirect()->route('head-mitcom.enforcer-stations.index')
            ->with('success', 'Station assignment removed.');
    }

}