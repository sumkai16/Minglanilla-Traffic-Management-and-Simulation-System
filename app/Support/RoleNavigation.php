<?php

namespace App\Support;

use App\Models\User;

class RoleNavigation
{
    public static function items(?User $user = null): array
    {
        $user ??= auth()->user();

        if (! $user instanceof User) {
            return [];
        }

        return match ($user->role) {
            'admin' => [
                self::item('Dashboard', route('admin.dashboard'), ['admin.dashboard'], 'dashboard'),
                self::item('Manage Users', route('admin.users.index'), ['admin.users.*'], 'users'),
                self::item('Traffic Reports', route('admin.reports.index'), ['admin.reports.*'], 'reports'),
                self::item('Live Traffic Map', route('admin.map'), ['admin.map'], 'map'),
                self::item('System Overview', route('admin.system'), ['admin.system'], 'system'),
                self::item('Audit Log', route('admin.audit-log'), ['admin.audit-log'], 'audit'),
                self::item('Profile', route('profile.edit'), ['profile.*'], 'profile'),
                
            ],
            'head-mitcom' => [
                self::item('Dashboard', route('head-mitcom.dashboard'), ['head-mitcom.dashboard'], 'dashboard'),
                self::item('Reports', route('head-mitcom.reports.index'), [
                    'head-mitcom.reports.create',
                    'head-mitcom.reports.index',
                    'head-mitcom.reports.show',
                    'head-mitcom.reports.assign',
                    'head-mitcom.reports.reassign',
                    'head-mitcom.reports.verify',
                    'head-mitcom.reports.reject',
                    'head-mitcom.reports.confirm-resolved',
                    'head-mitcom.reports.reject-resolved'
                ], 'reports'),
                self::item('Enforcers', route('head-mitcom.enforcers.index'), ['head-mitcom.enforcers.*'], 'enforcers'),
                self::item('Announcements', route('head-mitcom.announcements.index'), ['head-mitcom.announcements.*'], 'announcements'),
                self::item('Live Map', route('head-mitcom.map'), ['head-mitcom.map'], 'map'),
                self::item('Advisories', route('head-mitcom.advisories.index'), ['head-mitcom.advisories.*'], 'advisories'),
                self::item('Simulation', route('head-mitcom.simulation.index'), ['head-mitcom.simulation.*'], 'simulation'),
                self::item('Analysis', route('head-mitcom.analysis'), ['head-mitcom.analysis'], 'analysis'),
                self::item('Stations', route('head-mitcom.enforcer-stations.index'), ['head-mitcom.enforcer-stations'], 'enforcer-stations'),
                self::item('Profile', route('profile.edit'), ['profile.*'], 'profile'),
            ],
            'enforcer' => [
                self::item('Dashboard', route('enforcer.dashboard'), ['enforcer.dashboard'], 'dashboard'),
                self::item('Assigned Reports', route('enforcer.reports.index'), ['enforcer.reports.*'], 'reports'),
                self::item('Announcements', route('enforcer.announcements.index'), ['enforcer.announcements.*'], 'announcements', request()->routeIs('enforcer.announcements.*') && !request('type')),
                self::item('Traffic Advisories', route('enforcer.announcements.index', ['type' => 'traffic_advisory']), [], 'advisories', request()->routeIs('enforcer.announcements.*') && request('type') === 'traffic_advisory'),
                self::item('Profile', route('profile.edit'), ['profile.*'], 'profile'),
            ],
            default => [
                self::item('Dashboard', route('user.dashboard'), ['user.dashboard'], 'dashboard'),
                self::item('Report Incident', route('user.reports.create'), ['user.reports.*'], 'create'),
                self::item('Announcements', route('user.announcements.index'), ['user.announcements.*'], 'announcements'),
                self::item('Profile', route('profile.edit'), ['profile.*', 'user.profile.*'], 'profile'),
            ],
        };
    }

    public static function roleLabel(?User $user = null): string
    {
        $user ??= auth()->user();

        if (! $user instanceof User) {
            return 'Traffic System';
        }

        return match ($user->role) {
            'admin' => 'Admin Control',
            'head-mitcom' => 'Head MITCOM',
            'enforcer' => 'Enforcer Portal',
            default => 'Citizen Portal',
        };
    }

    public static function userDisplayName(?User $user = null): string
    {
        $user ??= auth()->user();

        if (! $user instanceof User) {
            return 'Guest';
        }

        $name = trim(collect([$user->first_name, $user->last_name])->filter()->implode(' '));

        return $name !== '' ? $name : ucfirst(str_replace('-', ' ', $user->role));
    }

    private static function item(string $label, string $href, array $routePatterns, string $icon, ?bool $active = null): array
    {
        return [
            'label' => $label,
            'href' => $href,
            'active' => $active ?? request()->routeIs(...$routePatterns),
            'icon' => $icon,
        ];
    }
}
