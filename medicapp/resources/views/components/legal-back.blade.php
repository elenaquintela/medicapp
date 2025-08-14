<a
  href="{{ auth()->check() ? route('dashboard') : url('/') }}"
  class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full shadow transition"
  onclick="
    if (document.referrer && document.referrer.startsWith(window.location.origin)) {
      history.back();
      return false;
    }
    return true;
  "
>
  Volver
</a>
