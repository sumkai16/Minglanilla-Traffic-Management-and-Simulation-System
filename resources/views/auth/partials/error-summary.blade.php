@if ($errors->any())
    <div class="auth-alert auth-alert--error" role="alert">
        <p class="auth-alert__title">Please review the highlighted fields.</p>
        <ul class="auth-error-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
