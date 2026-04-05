<x-app-nav title="Notifications" page-title="Notifications" page-eyebrow="Minglanilla Traffic Command"
    page-description="Stay informed with real-time updates on your reports, assignments, and system alerts.">

    <main class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl space-y-5">

            {{-- Summary bar --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-slate-500">
                    @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                    @if($unreadCount > 0)
                        You have <span class="font-semibold text-blue-600">{{ $unreadCount }}</span> unread
                        {{ Str::plural('notification', $unreadCount) }}.
                    @else
                        You're all caught up!
                    @endif
                </p>

                @if($unreadCount > 0)
                    <form method="POST" action="{{ route('notifications.read-all') }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 hover:text-blue-700">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                    clip-rule="evenodd" />
                            </svg>
                            Mark all as read
                        </button>
                    </form>
                @endif
            </div>

            {{-- Notification list --}}
            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
                @forelse($notifications as $notification)
                    <div
                        class="group flex items-start gap-4 border-b border-slate-100 px-6 py-5 transition last:border-b-0 {{ is_null($notification->read_at) ? 'bg-blue-50/60' : 'hover:bg-slate-50' }}">

                        {{-- Unread indicator --}}
                        <div class="mt-1.5 flex h-5 w-5 shrink-0 items-center justify-center">
                            @if(is_null($notification->read_at))
                                <span class="relative flex h-2.5 w-2.5">
                                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                                    <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                                </span>
                            @else
                                <span class="inline-flex h-2 w-2 rounded-full bg-slate-200"></span>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="min-w-0 flex-1">
                            <p class="text-sm leading-relaxed {{ is_null($notification->read_at) ? 'font-medium text-slate-800' : 'text-slate-600' }}">
                                {{ $notification->data['message'] }}
                            </p>
                            <p class="mt-1.5 text-xs text-slate-400">
                                <time datetime="{{ $notification->created_at->toIso8601String() }}">
                                    {{ $notification->created_at->diffForHumans() }}
                                </time>
                            </p>
                        </div>

                        {{-- Actions --}}
                        <div class="flex shrink-0 items-center gap-2">
                            @if(isset($notification->data['report_id']))
                                <a href="{{ auth()->user()->role === 'user' ? route('user.reports.show', $notification->data['report_id']) : route('enforcer.reports.show', $notification->data['report_id']) }}"
                                    class="inline-flex items-center gap-1.5 rounded-xl border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                                        <path fill-rule="evenodd"
                                            d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    View
                                </a>
                            @endif

                            @if(is_null($notification->read_at))
                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-500 transition hover:border-slate-300 hover:text-slate-700"
                                        title="Mark as read">
                                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Dismiss
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100">
                            <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-sm font-semibold text-slate-700">No notifications yet</h3>
                        <p class="mt-1.5 text-sm text-slate-400">When something happens, you'll see it here.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($notifications->hasPages())
                <div class="flex justify-center">
                    {{ $notifications->links() }}
                </div>
            @endif

        </div>
    </main>

</x-app-nav>