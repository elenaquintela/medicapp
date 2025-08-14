<a
  href="{{ auth()->check() ? route('dashboard') : url('/') }}"
  class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-white/20 hover:bg-white/10 transition"
  onclick="
    if (document.referrer && document.referrer.startsWith(window.location.origin)) {
      history.back();
      return false;
    }
    return true;
  "
>
  ← Volver
</a>
