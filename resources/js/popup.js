import Swal from 'sweetalert2';

// Security: Treat all server-provided text as plain text.
// Never use innerHTML. Use text/message only.

function safeText(value) {
    if (value === null || value === undefined) return '';
    return String(value);
}

function applyTheme() {
    return {
        background: '#fbf7f2',
        color: '#2b2016',
        confirmButtonColor: '#8B5E3C',
        cancelButtonColor: '#9f7a55',
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        borderRadius: 16,
        backdrop: 'rgba(17, 12, 8, 0.55)',
        showClass: {
            popup: 'swal2-animate__fadeInUp'
        },
        hideClass: {
            popup: 'swal2-animate__fadeOutDown'
        }
    };
}

function normalizeOptions(icon, title, text, extra = {}) {
    return {
        ...applyTheme(),
        icon,
        title: safeText(title),
        text: safeText(text),
        ...extra,
        // Make sure no HTML is interpreted
        html: undefined
    };
}

const MebelPopup = {
    success(message, title = 'Success') {
        return Swal.fire(
            normalizeOptions('success', title, message, {
                timer: 2500,
                toast: false,
                position: 'center',
                allowOutsideClick: false
            })
        );
    },

    error(message, title = 'Error') {
        return Swal.fire(
            normalizeOptions('error', title, message, {
                allowOutsideClick: false
            })
        );
    },

    warning(message, title = 'Warning') {
        return Swal.fire(
            normalizeOptions('warning', title, message, {
                allowOutsideClick: false
            })
        );
    },

    info(message, title = 'Info') {
        return Swal.fire(
            normalizeOptions('info', title, message, {
                timer: 2500,
                allowOutsideClick: true
            })
        );
    },

    toast({ title, icon = 'success', message, duration = 3000, position = 'top-end' }) {
        return Swal.fire({
            ...applyTheme(),
            toast: true,
            position,
            icon,
            title: safeText(title),
            text: safeText(message),
            showConfirmButton: false,
            timer: duration,
            timerProgressBar: true,
            allowOutsideClick: true,
            // Ensure no HTML
            html: undefined
        });
    },

    loading({ title = 'Please wait', text = 'Processing...' } = {}) {
        return Swal.fire({
            ...applyTheme(),
            title: safeText(title),
            text: safeText(text),
            icon: 'info',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            },
            // Ensure no HTML
            html: undefined
        });
    },

    close() {
        Swal.close();
    },

    // Confirm delete: works with Laravel method spoofing + CSRF.
    // The form must actually submit with method DELETE.
    confirmDelete({
        form,
        title = 'Are you sure?',
        text = 'This action cannot be undone.',
        confirmButtonText = 'Yes, delete',
        cancelButtonText = 'Cancel'
    }) {
        const formEl = form;
        if (!formEl || !(formEl instanceof HTMLElement)) {
            return Promise.reject(new Error('confirmDelete: form element is required'));
        }

        return Swal.fire({
            ...applyTheme(),
            icon: 'warning',
            title: safeText(title),
            text: safeText(text),
            showCancelButton: true,
            confirmButtonText: safeText(confirmButtonText),
            cancelButtonText: safeText(cancelButtonText),
            reverseButtons: true,
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                formEl.submit();
                return true;
            }
            return false;
        });
    }
};

// Global export
window.MebelPopup = MebelPopup;

export default MebelPopup;

