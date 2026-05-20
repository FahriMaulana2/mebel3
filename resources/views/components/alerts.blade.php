@php
    $success = session('success');
    $error = session('error');
    $warning = session('warning');
    $info = session('info');
@endphp

{{-- Centralized SweetAlert2 launcher for Laravel flash sessions. --}}
@if($success || $error || $warning || $info)
    <script>
        (function () {
            // Avoid memory leaks: run once per page load.
            const queue = [];
            @if($success)
                queue.push({ type: 'success', message: @json($success) });
            @endif
            @if($error)
                queue.push({ type: 'error', message: @json($error) });
            @endif
            @if($warning)
                queue.push({ type: 'warning', message: @json($warning) });
            @endif
            @if($info)
                queue.push({ type: 'info', message: @json($info) });
            @endif

            const run = () => {
                if (!window.MebelPopup) return;
                if (!queue.length) return;

                // Show first only to avoid notification spam.
                const item = queue[0];
                switch (item.type) {
                    case 'success':
                        window.MebelPopup.success(item.message);
                        break;
                    case 'error':
                        window.MebelPopup.error(item.message);
                        break;
                    case 'warning':
                        window.MebelPopup.warning(item.message);
                        break;
                    case 'info':
                        window.MebelPopup.info(item.message);
                        break;
                }
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', run, { once: true });
            } else {
                run();
            }
        })();
    </script>
@endif

