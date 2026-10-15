// Form Draft Persistence Helper
// Auto-saves form drafts to sessionStorage (keyed per form route), restores them
// on page load, and clears the draft on submission.
// Used by: pet_registration_form, kapon_form, vaccination_form, missing_pets_form
// Pattern follows public/js/breeds.js — plain script, loaded via asset().

window.FormPersistence = (function () {
    'use strict';

    var VERSION = 1;

    // ------------------------------------------------------------------
    // Storage primitives (fail-safe: never break the host page)
    // ------------------------------------------------------------------

    function storageKey(key) {
        return 'draft_' + key;
    }

    function load(key) {
        try {
            var raw = window.sessionStorage.getItem(storageKey(key));
            if (!raw) return null;
            var parsed = JSON.parse(raw);
            return (parsed && typeof parsed === 'object') ? parsed : null;
        } catch (err) {
            return null;
        }
    }

    function persist(key, payload) {
        try {
            window.sessionStorage.setItem(storageKey(key), JSON.stringify(payload));
            return true;
        } catch (err) {
            // Quota exceeded or storage unavailable (private mode) — drafts are best-effort.
            return false;
        }
    }

    function remove(key) {
        try {
            window.sessionStorage.removeItem(storageKey(key));
        } catch (err) {
            /* ignore */
        }
    }

    // ------------------------------------------------------------------
    // Serialization
    // ------------------------------------------------------------------

    var SKIP_TYPES = ['file', 'password', 'submit', 'button', 'image', 'reset', 'hidden'];
    var SKIP_NAMES = ['_token', '_method'];

    function shouldSkipField(el, excludeNames) {
        var type = (el.getAttribute('type') || '').toLowerCase();
        if (SKIP_TYPES.indexOf(type) !== -1) return true;
        var name = el.getAttribute('name');
        if (!name) return true;
        if (SKIP_NAMES.indexOf(name) !== -1) return true;
        if (el.hasAttribute('data-persist-ignore')) return true;
        if (excludeNames && excludeNames.indexOf(name) !== -1) return true;
        return false;
    }

    function serializeFields(form, excludeNames) {
        var fields = {};
        var elements = form.querySelectorAll('input, select, textarea');

        Array.prototype.forEach.call(elements, function (el) {
            if (shouldSkipField(el, excludeNames)) return;

            var name = el.getAttribute('name');
            var tag = el.tagName.toLowerCase();
            var type = (el.getAttribute('type') || '').toLowerCase();

            if (type === 'radio') {
                if (el.checked) fields[name] = el.value;
                return;
            }

            if (type === 'checkbox') {
                var group = form.querySelectorAll('input[type="checkbox"][name="' + cssEscape(name) + '"]');
                if (group.length > 1) {
                    if (!Array.isArray(fields[name])) fields[name] = [];
                    if (el.checked) fields[name].push(el.value);
                } else {
                    fields[name] = el.checked;
                }
                return;
            }

            if (tag === 'select') {
                // Multi-selects persist as arrays of selected values.
                if (el.multiple) {
                    var values = [];
                    Array.prototype.forEach.call(el.options, function (opt) {
                        if (opt.selected) values.push(opt.value);
                    });
                    fields[name] = values;
                } else {
                    fields[name] = el.value;
                }
                return;
            }

            // text-like inputs + textarea
            fields[name] = el.value;
        });

        return fields;
    }

    function restoreFields(form, fields, excludeNames) {
        if (!fields || typeof fields !== 'object') return;

        Object.keys(fields).forEach(function (name) {
            if (excludeNames && excludeNames.indexOf(name) !== -1) return;
            var value = fields[name];

            var elements = form.querySelectorAll(
                'input[name="' + cssEscape(name) + '"], select[name="' + cssEscape(name) + '"], textarea[name="' + cssEscape(name) + '"]'
            );
            if (!elements.length) return; // field no longer on the page

            var first = elements[0];
            var tag = first.tagName.toLowerCase();
            var type = (first.getAttribute('type') || '').toLowerCase();

            if (type === 'radio') {
                Array.prototype.forEach.call(elements, function (el) {
                    el.checked = (el.value === value);
                });
                return;
            }

            if (type === 'checkbox') {
                Array.prototype.forEach.call(elements, function (el) {
                    if (Array.isArray(value)) {
                        el.checked = value.indexOf(el.value) !== -1;
                    } else {
                        el.checked = value === true || el.value === value;
                    }
                });
                return;
            }

            Array.prototype.forEach.call(elements, function (el) {
                if (tag === 'select' && el.multiple && Array.isArray(value)) {
                    Array.prototype.forEach.call(el.options, function (opt) {
                        opt.selected = value.indexOf(opt.value) !== -1;
                    });
                    return;
                }
                if (value === null || value === undefined) return;
                // Skip values whose option no longer exists (stale draft).
                if (tag === 'select' && !el.multiple) {
                    var exists = false;
                    Array.prototype.forEach.call(el.options, function (opt) {
                        if (opt.value === value) exists = true;
                    });
                    if (!exists) return;
                }
                el.value = value;
            });
        });
    }

    // ------------------------------------------------------------------
    // Draft helpers
    // ------------------------------------------------------------------

    function hasRestorableContent(payload) {
        if (!payload) return false;

        var custom = payload.custom || {};
        for (var k in custom) {
            if (!Object.prototype.hasOwnProperty.call(custom, k)) continue;
            var cv = custom[k];
            if (Array.isArray(cv)) {
                if (cv.length > 0) return true;
            } else if (cv !== null && cv !== undefined && cv !== '' && cv !== 0 && cv !== 1 && cv !== false) {
                return true;
            }
        }

        var fields = payload.fields || {};
        for (var name in fields) {
            if (!Object.prototype.hasOwnProperty.call(fields, name)) continue;
            var val = fields[name];
            if (Array.isArray(val)) {
                if (val.length > 0) return true;
            } else if (val !== null && val !== undefined && val !== false && val !== '') {
                return true;
            }
        }
        return false;
    }

    function showRestoreToast(key) {
        if (document.getElementById('formDraftToast')) return;

        var toast = document.createElement('div');
        toast.id = 'formDraftToast';
        toast.className = 'fixed bottom-4 right-4 bg-emerald-700 text-white px-4 py-3 rounded-lg shadow-lg z-50 flex items-center gap-3';
        toast.setAttribute('role', 'status');

        var message = document.createElement('span');
        message.className = 'text-sm font-medium';
        message.textContent = 'Draft restored';

        var discardBtn = document.createElement('button');
        discardBtn.type = 'button';
        discardBtn.className = 'text-sm font-semibold underline hover:text-emerald-200';
        discardBtn.textContent = 'Discard draft';
        discardBtn.addEventListener('click', function () {
            remove(key);
            window.location.reload();
        });

        var dismissBtn = document.createElement('button');
        dismissBtn.type = 'button';
        dismissBtn.className = 'text-white hover:text-emerald-200';
        dismissBtn.setAttribute('aria-label', 'Dismiss');
        dismissBtn.innerHTML = '&times;';
        dismissBtn.addEventListener('click', function () {
            if (toast.parentNode) toast.parentNode.removeChild(toast);
        });

        toast.appendChild(message);
        toast.appendChild(discardBtn);
        toast.appendChild(dismissBtn);
        document.body.appendChild(toast);

        // Auto-dismiss after a while; the draft stays saved.
        setTimeout(function () {
            if (toast.parentNode) toast.parentNode.removeChild(toast);
        }, 10000);
    }

    // Escape a field name for safe use inside an attribute selector.
    function cssEscape(value) {
        if (window.CSS && typeof window.CSS.escape === 'function') {
            return window.CSS.escape(value);
        }
        return String(value).replace(/["\\\[\]]/g, '\\$&');
    }

    // ------------------------------------------------------------------
    // Public API
    // ------------------------------------------------------------------

    // init(key, options) -> { save, clear } handle for the page's own scripts.
    //
    // options.form              CSS selector of the <form>
    // options.userId            auth id or null (guards against cross-user restore)
    // options.skipRestore       true when the page rendered with validation errors
    // options.exclude           field names the serializer must ignore
    // options.custom.save()     captures JS state (selected pets, slots, step...)
    // options.custom.restore(o) re-renders JS-driven sections from that state
    // options.afterFieldRestore page-specific visibility / button-state sync
    function init(key, options) {
        options = options || {};
        var form = document.querySelector(options.form || 'form');
        if (!form) return null;

        var excludeNames = options.exclude || [];
        var saveTimer = null;

        function capturePayload() {
            var payload = {
                v: VERSION,
                savedAt: Date.now(),
                userId: typeof options.userId === 'undefined' ? null : options.userId,
                custom: {},
                fields: serializeFields(form, excludeNames)
            };
            if (options.custom && typeof options.custom.save === 'function') {
                try {
                    payload.custom = options.custom.save() || {};
                } catch (err) {
                    payload.custom = {};
                }
            }
            return payload;
        }

        function save() {
            persist(key, capturePayload());
        }

        function saveDebounced() {
            if (saveTimer) window.clearTimeout(saveTimer);
            saveTimer = window.setTimeout(save, 250);
        }

        function clear() {
            if (saveTimer) window.clearTimeout(saveTimer);
            remove(key);
        }

        // --- Auto-save: any input or change inside the form -----------------
        form.addEventListener('input', saveDebounced);
        form.addEventListener('change', saveDebounced);
        window.addEventListener('pagehide', save);

        // --- Auto-clear on submission --------------------------------------
        // Registered here (after the page's own listeners), so validation
        // failures that preventDefault() the submit keep the draft.
        form.addEventListener('submit', function (e) {
            if (!e.defaultPrevented) clear();
        });

        // --- Restore on load ------------------------------------------------
        function restore() {
            var payload = load(key);

            // Different user on the same tab: discard silently.
            var currentUser = typeof options.userId === 'undefined' ? null : options.userId;
            if (payload && typeof payload.userId !== 'undefined' && payload.userId !== currentUser) {
                remove(key);
                return;
            }

            // Server-side validation errors: old() data wins, skip restore.
            if (options.skipRestore) return;

            if (!payload) return;

            // 1. Rebuild JS-driven sections (selected pets, cards, slots, step).
            if (options.custom && typeof options.custom.restore === 'function') {
                try {
                    options.custom.restore(payload.custom || {});
                } catch (err) {
                    console.error('FormPersistence custom restore failed for', key, err);
                }
            }

            // 2. Restore plain field values.
            restoreFields(form, payload.fields || {}, excludeNames);

            // 3. Page-specific visibility / button-state sync.
            if (typeof options.afterFieldRestore === 'function') {
                try {
                    options.afterFieldRestore();
                } catch (err) {
                    console.error('FormPersistence afterFieldRestore failed for', key, err);
                }
            }

            if (hasRestorableContent(payload)) {
                showRestoreToast(key);
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', restore);
        } else {
            restore();
        }

        return {
            save: save,
            clear: clear
        };
    }

    return {
        init: init,
        VERSION: VERSION
    };
})();
