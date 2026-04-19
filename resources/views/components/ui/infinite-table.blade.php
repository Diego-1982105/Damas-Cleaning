{{--
  Table with a fixed-height viewport: the body scrolls; thead stays pinned at the top.
  Optional slots:
    above — fixed block above the scroll (titles, actions).
    below — fixed footer below the scroll (pagination).
  sticky-footer prop: keeps tfoot visible while scrolling (e.g. tables with a totals row).
--}}
@props([
    'maxHeight' => 'min(70vh, 36rem)',
    'stickyHeader' => true,
    'stickyFooter' => false,
])
@php
    $stickyClasses = $stickyHeader
        ? '[&_thead_th]:sticky [&_thead_th]:top-0 [&_thead_th]:z-10 [&_thead_th]:bg-brand-surface/95 [&_thead_th]:shadow-[inset_0_-1px_0_0_rgb(26_35_126/0.08)] [&_thead_th]:backdrop-blur-sm'
        : '';
    $footerSticky = $stickyFooter
        ? '[&_tfoot_td]:sticky [&_tfoot_td]:bottom-0 [&_tfoot_td]:z-10 [&_tfoot_td]:bg-brand-surface/95 [&_tfoot_td]:shadow-[inset_0_1px_0_0_rgb(26_35_126/0.08)] [&_tfoot_td]:backdrop-blur-sm'
        : '';
@endphp
<div {{ $attributes->class(['overflow-hidden rounded-2xl border border-brand-navy/10 bg-white shadow-sm']) }}>
    @isset($above)
        <div class="flex flex-col gap-2 border-b border-brand-navy/10 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            {{ $above }}
        </div>
    @endisset
    <div
        class="infinite-table-scroll overflow-auto overscroll-contain {{ $stickyClasses }} {{ $footerSticky }}"
        style="max-height: {{ e($maxHeight) }};"
    >
        {{ $slot }}
    </div>
    @isset($below)
        <div class="border-t border-brand-navy/10 bg-brand-surface/40 px-4 py-3">
            {{ $below }}
        </div>
    @endisset
</div>
