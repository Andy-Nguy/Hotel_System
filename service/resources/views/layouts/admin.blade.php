<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Admin') - Admin</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.svg') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/overlay-scroll/OverlayScrollbars.min.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>
<body>
    <div class="page-wrapper">
        <div class="main-container">

            {{-- Sidebar (extracted) --}}
            @include('partials.sidebar')

            {{-- App container --}}
            <div class="app-container">
                {{-- Header --}}
                <div class="app-header d-flex align-items-center">
                    <div class="d-flex">
                        <button class="pin-sidebar">
                            <i class="bi bi-list lh-1"></i>
                        </button>
                    </div>
                    <div class="d-flex align-items-center ms-3">
                        <h5 class="m-0">@yield('page-title', 'Admin')</h5>
                    </div>
                    <div class="app-brand-sm d-lg-none d-flex ms-auto">
                        <a href="#">
                            <img src="{{ asset('assets/images/logo-sm.svg') }}" class="logo" alt="AdminLite" />
                        </a>
                    </div>
                    <div class="header-actions">
                        <div class="d-flex">
                            <button class="toggle-sidebar">
                                <i class="bi bi-list lh-1"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Body / action area --}}
                <div class="app-body">
                    <div class="container-fluid">
                        <div id="alertArea"></div>
                        <div id="action-area">
                            @yield('content')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Global scripts --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/overlay-scroll/custom-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    @stack('scripts')

    {{-- Small AJAX partial loader for admin shell --}}
    <script>
        (function() {
            async function executeInlineScripts(container) {
                // Execute scripts in DOM order; wait for external scripts before running dependent inline ones
                const scripts = Array.from(container.querySelectorAll('script'));
                let sawDOMContentLoadedListener = false;
                for (const old of scripts) {
                    try {
                        const text = (old.innerHTML || '').toString();
                        if (text.includes('DOMContentLoaded') || text.includes("addEventListener('DOMContentLoaded'") || text.includes('addEventListener("DOMContentLoaded"')) {
                            sawDOMContentLoadedListener = true;
                        }
                        if (old.src) {
                            await new Promise((resolve, reject) => {
                                const s = document.createElement('script');
                                s.src = old.src;
                                if (old.type) s.type = old.type;
                                s.async = false; // preserve order
                                s.onload = () => { try { s.remove(); } catch {} resolve(); };
                                s.onerror = (err) => { try { s.remove(); } catch {} resolve(); };
                                document.body.appendChild(s);
                            });
                        } else {
                            const s = document.createElement('script');
                            if (old.type) s.type = old.type;
                            s.text = old.innerHTML;
                            document.body.appendChild(s);
                            s.parentNode && s.parentNode.removeChild(s);
                        }
                    } catch (e) { console.warn('executeInlineScripts error', e); }
                }
                return sawDOMContentLoadedListener;
            }

            // Simple lock to avoid re-entrant/concurrent partial loads which can cause duplicate requests
            window.__ajaxPartialInFlight = window.__ajaxPartialInFlight || false;
            async function loadPartial(url, pushState = true, pageName = null) {
                if (window.__ajaxPartialInFlight) {
                    console.debug('[loadPartial] ignoring request, another partial load in-flight ->', url);
                    return;
                }
                window.__ajaxPartialInFlight = true;
                try {
                    console.debug('[loadPartial] fetching', url);
                    const res = await fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        credentials: 'same-origin'
                    });
                    if (!res.ok) throw new Error('Network error');
                    let html = await res.text();
                    console.debug('[loadPartial] response length', html.length);
                    // If the response accidentally includes a full HTML document appended, strip it
                    const doctypeIdx = html.indexOf('<!DOCTYPE');
                    const htmlTagIdx = html.indexOf('<html');
                    const cutIdx = [doctypeIdx, htmlTagIdx].filter(i => i >= 0).sort((a,b)=>a-b)[0];
                    if (typeof cutIdx === 'number') {
                        console.debug('[loadPartial] trimming appended full document at index', cutIdx);
                        html = html.substring(0, cutIdx);
                    }
                    const container = document.createElement('div');
                    container.innerHTML = html;
                    const action = document.getElementById('action-area');
                    if (!action) return;

                    // If server returned a full layout, prefer its first non-empty #action-area fragment
                    let returnedAction = null;
                    if (container.querySelectorAll) {
                        const candidates = Array.from(container.querySelectorAll('#action-area'));
                        // pick first non-empty; if none non-empty, leave null to fall back to container content
                        returnedAction = candidates.find(c => (c.innerHTML || '').trim().length > 0) || null;
                    } else if (container.querySelector) {
                        returnedAction = container.querySelector('#action-area');
                    }
                    const injectSource = returnedAction || container;
                    const injectHtml = (injectSource && (injectSource.innerHTML || '')).trim();

                    // If there is no meaningful content in the fragment, don't replace the existing area.
                    if (!injectHtml) {
                        console.warn('[loadPartial] returned fragment empty, not replacing #action-area for', url);
                        // still attempt to call initializer if present (some pages may render via JS only)
                    } else {
                        // call optional destroy hook for current page to allow cleanup (convention: window.destroy<PascalName>)
                        try {
                            const curSegments = location.pathname.split('/').filter(Boolean);
                            const curName = curSegments.pop() || 'index';
                            const destroyName = 'destroy' + curName.replace(/[^a-zA-Z0-9]/g, '')[0]?.toUpperCase() + curName.slice(1);
                            if (window[destroyName] && typeof window[destroyName] === 'function') {
                                try { window[destroyName](); } catch (exDestroy) { console.warn('destroy hook threw', destroyName, exDestroy); }
                            }
                        } catch (e) { /* ignore */ }

                        action.innerHTML = injectSource.innerHTML || '';
                    }
                    // execute only scripts inside the chosen fragment to avoid running layout scripts twice
                    const sawDOMContentLoaded = await executeInlineScripts(injectSource);
                    // re-bind any data-ajax anchors in the newly injected content
                    try { bindDirectAjaxLinks(); } catch(e) { console.warn('bindDirectAjaxLinks failed after inject', e); }

                    // call page initializer if present (convention: window.init<PascalName>)
                    try {
                        // allow the fragment to tell us exactly which initializer/script to use
                        const fragInitEl = injectSource.querySelector('[data-init]');
                        const fragInit = fragInitEl ? fragInitEl.getAttribute('data-init') : null;
                        const fragPageEl = injectSource.querySelector('[data-page]');
                        const fragPage = fragPageEl ? fragPageEl.getAttribute('data-page') : null;

                        let normalized = pageName || fragPage || null;
                        if (!normalized) {
                            const body = new URL(url, window.location.origin).pathname;
                            const rawName = body.split('/').filter(Boolean).pop() || 'index';
                            normalized = rawName.replace(/[^a-zA-Z0-9]/g, '');
                        }
                        const fnName = fragInit || ('init' + (normalized[0] ? normalized[0].toUpperCase() + normalized.slice(1) : 'Index'));

                        const scriptUrl = `${window.location.origin}/assets/js/pages/${normalized}.js`;
                        console.debug('[loadPartial] page detection', { rawName, normalized, fnName, scriptUrl });

                        let calledInit = false;
                        // If the initializer is already present (maybe inline script), call it.
                        if (window[fnName] && typeof window[fnName] === 'function') {
                            console.debug('[loadPartial] calling existing initializer', fnName);
                            const possible = window[fnName]();
                            if (possible && typeof possible.then === 'function') await possible;
                            calledInit = true;
                        } else {
                            // Otherwise try to load the static per-page script (if it exists) and then call initializer.
                            if (!document.querySelector(`script[src="${scriptUrl}"]`)) {
                                try {
                                    await new Promise((resolve, reject) => {
                                        const s = document.createElement('script');
                                        s.src = scriptUrl;
                                        s.async = true;
                                        s.onload = () => { resolve(); };
                                        s.onerror = (err) => { reject(err); };
                                        document.body.appendChild(s);
                                    });
                                    console.debug('[loadPartial] loaded script', scriptUrl);
                                } catch (err) {
                                    // ignore load errors - initializer may not exist for some pages
                                    console.warn('[loadPartial] failed to load per-page script', scriptUrl, err);
                                }
                            } else {
                                console.debug('[loadPartial] per-page script already present', scriptUrl);
                            }

                            if (window[fnName] && typeof window[fnName] === 'function') {
                                console.debug('[loadPartial] calling initializer after script load', fnName);
                                const possible = window[fnName]();
                                if (possible && typeof possible.then === 'function') await possible;
                                calledInit = true;
                            } else if (window.init && typeof window.init === 'function') {
                                // fallback: some fragments register a generic init() function inline
                                console.debug('[loadPartial] calling fallback init()');
                                try { const p = window.init(); if (p && typeof p.then === 'function') await p; } catch (exFallback) { console.warn('fallback init() threw', exFallback); }
                                calledInit = true;
                            } else {
                                console.debug('[loadPartial] initializer not found after script load', fnName);
                            }
                        }

                        // Ultimate DOM-based fallback: detect known page elements and call their initializers
                        if (!calledInit) {
                            try {
                                if (injectSource.querySelector('#tableTienNghi') && window.initTiennghi) {
                                    console.debug('[loadPartial] DOM fallback -> calling initTiennghi()');
                                    const p = window.initTiennghi();
                                    if (p && typeof p.then === 'function') await p;
                                    calledInit = true;
                                } else if (injectSource.querySelector('#tablePhong') && window.initPhong) {
                                    console.debug('[loadPartial] DOM fallback -> calling initPhong()');
                                    const p = window.initPhong();
                                    if (p && typeof p.then === 'function') await p;
                                    calledInit = true;
                                }
                            } catch (exDom) { console.warn('DOM fallback init error', exDom); }
                        }

                        // Final safety: after the browser paints, re-read [data-init] from the live DOM and try once more
                        if (!calledInit) {
                            setTimeout(async () => {
                                try {
                                    const live = document.getElementById('action-area');
                                    const el = live ? live.querySelector('[data-init]') : null;
                                    const liveInit = el ? el.getAttribute('data-init') : null;
                                    if (liveInit && typeof window[liveInit] === 'function') {
                                        console.debug('[loadPartial] live DOM retry -> calling', liveInit);
                                        const p = window[liveInit]();
                                        if (p && typeof p.then === 'function') await p;
                                    }
                                } catch (exLive) { console.warn('live DOM init retry error', exLive); }
                            }, 0);
                        }
                    } catch (e) { console.error('Error running page initializer', e); }

                    if (pushState) history.pushState({ url }, '', url);

                    // If the injected fragment contained scripts that added DOMContentLoaded listeners,
                    // dispatch a synthetic event so those handlers run (mimic initial load behavior).
                    try {
                        if (sawDOMContentLoaded) {
                            console.debug('[loadPartial] dispatching synthetic DOMContentLoaded for injected fragment');
                            document.dispatchEvent(new Event('DOMContentLoaded'));
                        }
                    } catch (e) { console.warn('dispatch DOMContentLoaded failed', e); }
                } catch (e) {
                    console.error('Partial load failed', e);
                } finally {
                    window.__ajaxPartialInFlight = false;
                }
            }

            // Intercept clicks on links with data-ajax (robust delegate)
            document.addEventListener('click', function(e) {
                try {
                    // ignore modified clicks / non-left buttons
                    if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;

                    // find nearest anchor with data-ajax attribute
                    const a = e.target && (e.target.closest ? e.target.closest('a[data-ajax], a[data-ajax="true"]') : null);
                    if (!a) return;

                    const href = a.getAttribute('href') || a.dataset.href;
                    if (!href) return;
                    // allow external links
                    if (href.indexOf('http') === 0 && !href.startsWith(window.location.origin)) return;

                    e.preventDefault();
                    const pageName = a.getAttribute('data-page') || a.dataset.page || null;
                    console.debug('[ajax-nav] delegate ->', href, { pageName });
                    // attempt AJAX navigation; fall back to full navigation on error
                    Promise.resolve(loadPartial(href, true, pageName)).catch(err => {
                        console.error('AJAX navigation failed, falling back to full navigation', err);
                        window.location.href = href;
                    });
                } catch (ex) {
                    console.error('click handler error', ex);
                }
            });

            // Also bind directly to anchors with data-ajax to be extra-reliable (sidebar links etc.)
            function bindDirectAjaxLinks() {
                try {
                    document.querySelectorAll && document.querySelectorAll('a[data-ajax]').forEach(a => {
                        if (a._ajaxBound) return;
                        a.addEventListener('click', function(ev) {
                            try {
                                if (ev.defaultPrevented) return;
                                // ignore modified clicks
                                if (ev.button !== 0 || ev.metaKey || ev.ctrlKey || ev.shiftKey || ev.altKey) return;
                                const href = a.getAttribute('href') || a.dataset.href;
                                if (!href) return;
                                ev.preventDefault();
                                const pageName = a.getAttribute('data-page') || a.dataset.page || null;
                                console.debug('[ajax-nav] direct ->', href, { pageName });
                                Promise.resolve(loadPartial(href, true, pageName)).catch(err => {
                                    console.error('AJAX navigation failed (direct), falling back', err);
                                    window.location.href = href;
                                });
                            } catch (ex2) { console.error('direct click handler error', ex2); }
                        });
                        a._ajaxBound = true;
                    });
                } catch (e) { console.error('bindDirectAjaxLinks error', e); }
            }

            // Bind now and bind again after DOMContentLoaded in case links are added later
            bindDirectAjaxLinks();
            document.addEventListener('DOMContentLoaded', bindDirectAjaxLinks);

            window.addEventListener('popstate', function(e) {
                if (e.state && e.state.url) loadPartial(e.state.url, false);
            });

            // On initial full page load, call initializer if present
            document.addEventListener('DOMContentLoaded', function() {
                try {
                    const segments = location.pathname.split('/').filter(Boolean);
                    const name = segments.pop() || 'index';
                    const fnName = 'init' + name.replace(/[^a-zA-Z0-9]/g, '')[0]?.toUpperCase() + name.slice(1);
                    if (window[fnName] && typeof window[fnName] === 'function') window[fnName]();
                } catch (e) {}
            });
        })();
    </script>
</body>
</html>