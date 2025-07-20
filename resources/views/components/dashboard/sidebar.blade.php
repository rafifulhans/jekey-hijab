@php
    $submenu_laporan_keuangan = [
        ['link' => route('jurnal-transaksi'), 'icon' => 'ti ti-circle', 'title' => 'Jurnal Transaksi'],
        ['link' => route('jurnal-umum'), 'icon' => 'ti ti-circle', 'title' => 'Jurnal Umum'],
        ['link' => route('buku-besar'), 'icon' => 'ti ti-circle', 'title' => 'Buku Besar'],
        ['link' => route('jurnal-penyesuaian'), 'icon' => 'ti ti-circle', 'title' => 'Jurnal Penyesuaian'],
        ['link' => route('neraca-saldo'), 'icon' => 'ti ti-circle', 'title' => 'Neraca Saldo'],
        ['link' => route('laba-rugi'), 'icon' => 'ti ti-circle', 'title' => 'Laba / Rugi'],
        ['link' => route('arus-kas'), 'icon' => 'ti ti-circle', 'title' => 'Arus Kas']
    ];

/*
    if (auth()->user()->role == 1) { // pemimpin
        $submenu_laporan_keuangan[] = ['link' => route('jurnal-penyesuaian'), 'icon' => 'ti ti-circle', 'title' => 'Jurnal Penyesuaian'];
        $submenu_laporan_keuangan[] = ['link' => route('arus-kas'), 'icon' => 'ti ti-circle', 'title' => 'Arus Kas'];
    }
*/
@endphp

@switch(auth()->user()->role)
    @case(1)
        <x-dashboard.sidebar-link icon="ti ti-atom" link="{{ route('dashboard') }}" title="Dashboard" />
        <x-dashboard.sidebar-link icon="ti ti-aperture" link="{{ route('penjualan') }}" title="Riwayat Penjualan" />
        <x-dashboard.sidebar-link-dropdown :submenus="$submenu_laporan_keuangan" :icon="'ti ti-layout-grid'"
            link="{{ route('laba-rugi') }}" title="Laporan Keuangan"></x-dashboard.sidebar-link-dropdown>
        <x-dashboard.sidebar-link-dropdown :submenus="[
                    ['link' => route('piutang'), 'icon' => 'ti ti-circle', 'title' => 'Piutang'],
                    ['link' => route('utang'), 'icon' => 'ti ti-circle', 'title' => 'Utang']
                ]" :icon="'ti ti-aperture'"
            link="{{ route('piutang') }}" icon="ti ti-clipboard" title="Piutang / Utang"></x-dashboard.sidebar-link-dropdown>
        <x-dashboard.sidebar-link icon="ti ti-server" link="{{ route('pengeluaran-grosir') }}" title="Pengeluaran Grosir" />
        @break
    @case(2)
        <x-dashboard.sidebar-link icon="ti ti-shopping-cart" link="{{ route('penjualan') }}" title="Penjualan" />
        <x-dashboard.sidebar-link icon="ti ti-receipt" link="{{ route('invoice') }}" title="Invoice" />
        @break
    @case(3)
        <x-dashboard.sidebar-link icon="ti ti-aperture" link="{{ route('penjualan') }}" title="Riwayat Penjualan" />
        <x-dashboard.sidebar-link-dropdown :submenus="$submenu_laporan_keuangan" :icon="'ti ti-layout-grid'"
            link="{{ route('laba-rugi') }}" title="Laporan Keuangan"></x-dashboard.sidebar-link-dropdown>
        <x-dashboard.sidebar-link-dropdown :submenus="[
                    ['link' => route('piutang'), 'icon' => 'ti ti-circle', 'title' => 'Piutang'],
                    ['link' => route('utang'), 'icon' => 'ti ti-circle', 'title' => 'Utang']
                ]" :icon="'ti ti-aperture'"
            link="{{ route('piutang') }}" icon="ti ti-clipboard" title="Piutang / Utang"></x-dashboard.sidebar-link-dropdown>
        <x-dashboard.sidebar-link icon="ti ti-server" link="{{ route('pengeluaran-grosir') }}" title="Pengeluaran Grosir" />
        @break

@endswitch
