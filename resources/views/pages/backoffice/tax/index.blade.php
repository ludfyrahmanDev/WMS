@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <!-- Modern Header -->
    <div class="flex items-center justify-between mb-8 pt-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">{{ $title }}</h1>
            <p class="text-slate-600 mt-2">Kelola pengaturan pajak perusahaan dengan sistem terintegrasi</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 p-3 rounded-lg text-white shadow-lg">
                <x-base.lucide class="w-6 h-6" icon="Calculator" />
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <x-base.alert class="mb-6 flex items-center bg-green-50 border-green-200 text-green-800" variant="outline-success">
            <x-base.lucide class="mr-3 h-5 w-5 text-green-500" icon="CheckCircle" />
            <div class="flex-1">{{ session('success') }}</div>
            <x-base.alert.dismiss-button class="text-green-500 hover:text-green-700 ml-4">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif
    @if (session('failed'))
        <x-base.alert class="mb-6 flex items-center bg-red-50 border-red-200 text-red-800" variant="outline-danger">
            <x-base.lucide class="mr-3 h-5 w-5 text-red-500" icon="AlertCircle" />
            <div class="flex-1">{{ session('failed') }}</div>
            <x-base.alert.dismiss-button class="text-red-500 hover:text-red-700 ml-4">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-100 text-sm">Total CV</p>
                    <p class="text-2xl font-bold">{{ $data->count() ?? 0 }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-emerald-200" icon="Building2" />
            </div>
        </div>
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Rata-rata Pajak</p>
                    <p class="text-2xl font-bold">{{ number_format($data->avg('percentage') ?? 0, 1) }}%</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-blue-200" icon="Percent" />
            </div>
        </div>
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Pajak Tertinggi</p>
                    <p class="text-2xl font-bold">{{ $data->max('percentage') ?? 0 }}%</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-purple-200" icon="TrendingUp" />
            </div>
        </div>
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-4 rounded-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">CV Aktif</p>
                    <p class="text-2xl font-bold">{{ $data->where('status', 'active')->count() ?? $data->count() }}</p>
                </div>
                <x-base.lucide class="w-8 h-8 text-orange-200" icon="CheckCircle2" />
            </div>
        </div>
    </div>
    <!-- Actions & Filters -->
    <div class="mt-8 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12">
            <div class="box p-5">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <!-- Actions -->
                    <div class="flex items-center gap-3">
                        {{-- <a href="{{ route($route . '.create') }}">
                            <x-base.button variant="primary" :disabled="$data->total() == $cvs->count()">
                                Tambah Data Pajak
                            </x-base.button>
                        </a> --}}
                        
                        <div class="text-sm text-slate-600 bg-slate-50 px-3 py-2 rounded-lg">
                            <span class="font-medium">{{ $data->total() }}</span> dari <span class="font-medium">{{ $cvs->count() ?? 0 }}</span> CV telah dikonfigurasi
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="flex flex-col sm:flex-row gap-3 lg:w-auto w-full">
                        <x-base.form-input 
                            class="!box w-full sm:w-56" 
                            type="text" 
                            id="search"
                            value="{{ request()->get('search') }}" 
                            placeholder="Cari CV atau pajak..." 
                        />
                    </div>
                </div>
                
                <!-- Data Info -->
                <div class="text-slate-500 text-sm mt-3 pt-3 border-t">
                    Menampilkan 1 hingga {{ $data->count() }} dari {{ $data->count() }} data
                </div>
            </div>
        </div>


        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12">
            <div class="box">
                <!-- Table Header -->
                <div class="p-5 border-b">
                    <h3 class="text-lg font-semibold">Daftar Pengaturan Pajak CV</h3>
                </div>

                <!-- Table Content -->
                <div class="overflow-hidden">
                    <x-base.table class="border-spacing-y-[10px] border-separate">
                        <x-base.table.thead>
                            <x-base.table.tr>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    No
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Nama CV
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Persentase Pajak
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Status
                                </x-base.table.th>
                                <x-base.table.th class="border-b-0 font-semibold text-center">
                                    Aksi
                                </x-base.table.th>
                            </x-base.table.tr>
                        </x-base.table.thead>
                        <x-base.table.tbody>
                            @foreach ($data as $item)
                                <x-base.table.tr class="intro-x hover:bg-slate-50 transition-colors">
                                    <x-base.table.td class="text-center py-4">
                                        {{ $loop->iteration }}
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        <div class="font-semibold text-slate-800">{{ $item->cv->name }}</div>
                                        <div class="text-sm text-slate-500">CV {{ $item->cv->name }}</div>
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        <div class="inline-flex items-center px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full font-semibold">
                                            <x-base.lucide class="w-4 h-4 mr-1" icon="Percent" />
                                            {{ $item->percentage }}%
                                        </div>
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        <div class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                            <x-base.lucide class="w-3 h-3 mr-1" icon="CheckCircle2" />
                                            Aktif
                                        </div>
                                    </x-base.table.td>
                                    <x-base.table.td class="text-center py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <x-base.button 
                                                size="sm" 
                                                variant="outline-warning"
                                                as="a"
                                                href="{{ route('tax.edit', $item->id) }}">
                                                <x-base.lucide class="w-4 h-4 mr-1" icon="Edit" />
                                                Edit
                                            </x-base.button>
                                            @if ($item->stock_count == 0)
                                                <x-base.button 
                                                    size="sm" 
                                                    variant="outline-danger"
                                                    data-tw-toggle="modal"
                                                    data-tw-target="#delete-confirmation-modal-{{ $item->id }}">
                                                    <x-base.lucide class="w-4 h-4 mr-1" icon="Trash2" />
                                                    Hapus
                                                </x-base.button>
                                            @endif
                                        </div>

                                        <!-- Delete Confirmation Modal -->
                                        <x-base.dialog id="delete-confirmation-modal-{{ $item->id }}">
                                            <x-base.dialog.panel>
                                                <div class="p-8 text-center">
                                                    <h3 class="text-xl font-semibold mb-4">Hapus Pengaturan Pajak</h3>
                                                    <p class="text-slate-500 mb-4">
                                                        Apakah Anda yakin ingin menghapus pengaturan pajak untuk CV ini?
                                                    </p>
                                                    <div class="bg-slate-50 p-3 rounded mb-4">
                                                        <div class="text-sm text-slate-600">
                                                            <strong>CV:</strong> {{ $item->cv->name }}<br>
                                                            <strong>Pajak:</strong> {{ $item->percentage }}%
                                                        </div>
                                                    </div>
                                                    <p class="text-xs text-red-600">
                                                        Tindakan ini tidak dapat dibatalkan
                                                    </p>
                                                </div>
                                                <div class="px-8 pb-8 flex justify-center gap-3">
                                                    <x-base.button data-tw-dismiss="modal" type="button" variant="outline-secondary">
                                                        Batal
                                                    </x-base.button>
                                                    <form action="{{ route('tax.destroy', $item->id) }}" method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <x-base.button type="submit" variant="danger">
                                                            Ya, Hapus
                                                        </x-base.button>
                                                    </form>
                                                </div>
                                            </x-base.dialog.panel>
                                        </x-base.dialog>
                                    </x-base.table.td>
                                </x-base.table.tr>
                            @endforeach

                            <!-- Empty State -->
                            @if ($data->isEmpty())
                                <x-base.table.tr>
                                    <x-base.table.td colspan="5" class="py-16 text-center">
                                        <div>
                                            <h3 class="text-lg font-semibold mb-2">Belum Ada Pengaturan Pajak</h3>
                                            <p class="text-slate-500 mb-4">
                                                Belum ada pengaturan pajak yang dikonfigurasi untuk CV.
                                            </p>
                                        </div>
                                    </x-base.table.td>
                                </x-base.table.tr>
                            @endif
                        </x-base.table.tbody>
                    </x-base.table>
                </div>
            </div>
        </div>
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <x-base.pagination.base :data="$data"></x-base.pagination.base>
        <!-- END: Pagination -->
    </div>
    <!-- BEGIN: Delete Confirmation Modal -->
    <x-base.dialog id="delete-confirmation-modal">
        <x-base.dialog.panel>
            <div class="p-5 text-center">
                <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
                <div class="mt-5 text-3xl">Apakah anda yakin?</div>
                <div class="mt-2 text-slate-500">
                    Proses ini tidak dapat dibatalkan.
                </div>
            </div>
            <div class="px-5 pb-8 text-center">
                <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button" variant="outline-secondary">
                    Cancel
                </x-base.button>
                <x-base.button class="w-24" type="button" variant="danger">
                    Delete
                </x-base.button>
            </div>
        </x-base.dialog.panel>
    </x-base.dialog>
    <!-- END: Delete Confirmation Modal -->
@endsection

@push('js')
<script>
    // Search functionality
    let searchTimeout;
    const searchInput = document.getElementById('search');

    function performSearch() {
        const searchValue = searchInput.value;
        const params = new URLSearchParams(window.location.search);
        
        if (searchValue) {
            params.set('search', searchValue);
        } else {
            params.delete('search');
        }

        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }

    // Debounced search for text input
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performSearch, 500);
        });
    }

    // Auto-dismiss alerts
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                if (alert && alert.parentNode) {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }
            }, 5000);
        });
    });

    // Enhanced table interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effects to table rows
        const tableRows = document.querySelectorAll('table tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8fafc';
                this.style.transform = 'scale(1.01)';
                this.style.transition = 'all 0.2s ease';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
                this.style.transform = '';
            });
        });

        // Smooth scroll to top when pagination changes
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });

        // Animate percentage badges
        const percentageBadges = document.querySelectorAll('.bg-emerald-100');
        percentageBadges.forEach((badge, index) => {
            badge.style.animation = `slideInRight 0.5s ease-in-out ${index * 0.1}s both`;
        });
    });

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
