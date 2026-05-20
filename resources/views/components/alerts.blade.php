@php
    $success = session('success');
    $error = session('error');
    $warning = session('warning');
    $info = session('info');
@endphp

@if($success || $error || $warning || $info)
<script>
(function () {

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

    function runPopup() {

        if (!window.MebelPopup) {
            setTimeout(runPopup, 100);
            return;
        }

        if (!queue.length) return;

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
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', runPopup, { once: true });
    } else {
        runPopup();
    }

})();
</script>
@endif