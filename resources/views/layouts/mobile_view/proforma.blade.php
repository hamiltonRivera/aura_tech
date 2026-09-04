<div class="pt-2 pb-3 space-y-1">
        @can('procesos.diarios')
            <x-responsive-nav-link href="{{ route('proforma') }}">
                <i class="fa-solid fa-bag-shopping"></i> {{ __('Proforma') }}
            </x-responsive-nav-link>
        @endcan
</div>