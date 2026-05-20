// Event bindings for reusable SweetAlert2 popups.
// Uses event delegation to avoid per-element listeners (prevents memory leaks).

function getDataset(el, key) {
    if (!el) return undefined;
    return el.dataset ? el.dataset[key] : undefined;
}

function safeText(value) {
    if (value === null || value === undefined) return '';
    return String(value);
}

function isConfirmDeleteForm(form) {
    if (!form || !(form instanceof HTMLElement)) return false;
    return form.dataset && form.dataset.mebelPopup === 'confirm-delete';
}

function setupBindings() {
    // Confirm delete (forms)
    document.addEventListener('click', async (e) => {
        const target = e.target;
        if (!target) return;

        const submitButton = target instanceof Element ? target.closest('button[type="submit"], button') : null;
        const form = submitButton ? submitButton.closest('form') : null;

        if (!isConfirmDeleteForm(form)) return;

        // Prevent normal submit until confirmed
        e.preventDefault();
        e.stopPropagation();

        const title = safeText(getDataset(form, 'title') || 'Are you sure?');
        const message = safeText(getDataset(form, 'message') || 'This action cannot be undone.');

        if (window.MebelPopup && typeof window.MebelPopup.confirmDelete === 'function') {
            await window.MebelPopup.confirmDelete({
                form,
                title,
                text: message,
                confirmButtonText: safeText(getDataset(form, 'confirmText') || 'Yes, delete'),
                cancelButtonText: safeText(getDataset(form, 'cancelText') || 'Cancel')
            });
        }
    });

    // Loading popup for actions: elements can declare data attributes.
    // data-mebel-loading="checkout|upload-payment|submit-order|admin-process"
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (!(form instanceof HTMLFormElement)) return;

        const loadingType = form.dataset ? form.dataset.mebelLoading : undefined;
        if (!loadingType) return;

        if (!window.MebelPopup || typeof window.MebelPopup.loading !== 'function') return;

        let title = 'Please wait';
        let text = 'Processing...';

        switch (loadingType) {
            case 'checkout':
                title = 'Checkout';
                text = 'Saving your order...';
                break;
            case 'upload-payment':
                title = 'Payment';
                text = 'Uploading payment proof...';
                break;
            case 'submit-order':
                title = 'Order';
                text = 'Submitting your order...';
                break;
            case 'admin-process':
                title = 'Admin';
                text = 'Updating request...';
                break;
            default:
                break;
        }

        window.MebelPopup.loading({ title, text });
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupBindings, { once: true });
} else {
    setupBindings();
}

export {};

