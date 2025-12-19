@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <!-- Modern Page Header -->
    <div class="intro-y mt-8">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-xl">
                    <x-base.lucide class="w-6 h-6 text-blue-600" icon="Building2" />
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">{{ $title }}</h1>
                    <p class="text-slate-600 mt-1">Kelola data CV perusahaan</p>
                </div>
            </div>
            <div class="flex items-center space-x-2 text-sm text-slate-500">
                <x-base.lucide class="w-4 h-4" icon="Calendar" />
                <span>{{ now()->format('d M Y') }}</span>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4 rounded-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">Total CV</p>
                        <p class="text-2xl font-bold">{{ $data->total() ?? 0 }}</p>
                    </div>
                    <x-base.lucide class="w-8 h-8 text-blue-200" icon="Building2" />
                </div>
            </div>
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-4 rounded-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm">CV Terdaftar</p>
                        <p class="text-2xl font-bold">{{ $data->count() ?? 0 }}</p>
                    </div>
                    <x-base.lucide class="w-8 h-8 text-purple-200" icon="FileText" />
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <x-base.alert class="mb-6 flex items-center bg-emerald-50 border-emerald-200" variant="outline-success" data-dismissible="true">
            <x-base.lucide class="mr-3 h-5 w-5 text-emerald-600" icon="CheckCircle" />
            <span class="text-emerald-800">{{ session('success') }}</span>
            <x-base.alert.dismiss-button class="btn-close ml-auto" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif

    @if (session('failed'))
        <x-base.alert class="mb-6 flex items-center bg-red-50 border-red-200" variant="outline-danger" data-dismissible="true">
            <x-base.lucide class="mr-3 h-5 w-5 text-red-600" icon="AlertCircle" />
            <span class="text-red-800">{{ session('failed') }}</span>
            <x-base.alert.dismiss-button class="btn-close ml-auto" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif

    <!-- Action Bar -->
    <div class="intro-y mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <!-- Left Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route($route . '.create') }}">
                        <x-base.button class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white shadow-lg shadow-blue-600/20" variant="primary">
                            <x-base.lucide class="w-4 h-4 mr-2" icon="Plus" />
                            Tambah CV
                        </x-base.button>
                    </a>
                </div>

                <!-- Search -->
                <div class="relative flex-1 max-w-md">
                    <x-base.lucide class="absolute inset-y-0 left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-slate-400" icon="Search" />
                    <x-base.form-input 
                        class="pl-10 pr-4 py-2.5 rounded-lg border-slate-300 focus:border-blue-500 focus:ring-blue-500" 
                        id="search" 
                        type="text" 
                        placeholder="Cari CV berdasarkan nama, NPWP..." 
                        value="{{ request('search') }}" 
                    />
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="overflow-x-auto">
                <x-base.table class="border-spacing-y-[10px] border-separate">
                    <x-base.table.thead class="bg-slate-50">
                        <x-base.table.tr>
                            <x-base.table.th class="py-4 px-6 border-b-2 border-slate-200 whitespace-nowrap font-semibold text-slate-700">
                                No
                            </x-base.table.th>
                            <x-base.table.th class="py-4 px-6 border-b-2 border-slate-200 whitespace-nowrap font-semibold text-slate-700">
                                Nama CV
                            </x-base.table.th>
                            <x-base.table.th class="py-4 px-6 border-b-2 border-slate-200 whitespace-nowrap font-semibold text-slate-700">
                                NPWP
                            </x-base.table.th>
                            <x-base.table.th class="py-4 px-6 border-b-2 border-slate-200 whitespace-nowrap font-semibold text-slate-700">
                                Alamat
                            </x-base.table.th>
                            <x-base.table.th class="py-4 px-6 border-b-2 border-slate-200 whitespace-nowrap font-semibold text-slate-700">
                                Deskripsi
                            </x-base.table.th>
                            <x-base.table.th class="py-4 px-6 border-b-2 border-slate-200 text-center whitespace-nowrap font-semibold text-slate-700">
                                Aksi
                            </x-base.table.th>
                        </x-base.table.tr>
                    </x-base.table.thead>
                    <x-base.table.tbody>
                        @forelse ($data as $item)
                            <x-base.table.tr class="hover:bg-slate-50 transition-colors duration-200">
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200">
                                    <span class="text-slate-700">{{ $data->firstItem() + $loop->index }}</span>
                                </x-base.table.td>
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <x-base.lucide class="w-5 h-5 text-blue-600" icon="Building2" />
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-800">{{ $item->name }}</div>
                                        </div>
                                    </div>
                                </x-base.table.td>
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200">
                                    <span class="text-slate-700">{{ $item->npwp ?? '-' }}</span>
                                </x-base.table.td>
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200">
                                    <div class="flex items-center">
                                        <x-base.lucide class="w-4 h-4 mr-2 text-slate-400" icon="MapPin" />
                                        <span class="text-slate-700 truncate max-w-xs">{{ $item->address ?? '-' }}</span>
                                    </div>
                                </x-base.table.td>
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200">
                                    <span class="text-slate-700 truncate max-w-xs">{{ Str::limit($item->description, 50) ?? '-' }}</span>
                                </x-base.table.td>
                                <x-base.table.td class="py-4 px-6 border-b border-slate-200">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('cv.edit', $item->id) }}">
                                            <x-base.button 
                                                class="px-3 py-2 text-xs bg-primary/10 text-primary hover:bg-primary/20 border border-primary/20" 
                                                variant="outline-primary">
                                                <x-base.lucide class="w-3 h-3 mr-1" icon="Edit" />
                                                Edit
                                            </x-base.button>
                                        </a>
                                        <x-base.button 
                                            class="px-3 py-2 text-xs bg-danger/10 text-danger hover:bg-danger/20 border border-danger/20" 
                                            data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal-{{ $item->id }}"
                                            variant="outline-danger">
                                            <x-base.lucide class="w-3 h-3 mr-1" icon="Trash2" />
                                            Hapus
                                        </x-base.button>
                                    </div>

                                    <!-- Delete Confirmation Modal -->
                                    <x-base.dialog id="delete-confirmation-modal-{{ $item->id }}">
                                        <x-base.dialog.panel>
                                            <div class="p-5 text-center">
                                                <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
                                                <div class="mt-5 text-3xl">Apakah anda yakin?</div>
                                                <div class="mt-2 text-slate-500">
                                                    Proses ini tidak dapat dibatalkan.
                                                </div>
                                            </div>
                                            <div class="px-5 pb-8 text-center flex justify-center">
                                                <x-base.button class="mr-1 w-24" data-tw-dismiss="modal" type="button"
                                                    variant="outline-secondary">
                                                    Cancel
                                                </x-base.button>
                                                <form action="{{ route('cv.destroy', $item->id) }}" method="post"
                                                    class="w-24">
                                                    @method('delete')
                                                    @csrf
                                                    <x-base.button class="w-24" type="submit" variant="danger">
                                                        Delete
                                                    </x-base.button>
                                                </form>
                                            </div>
                                        </x-base.dialog.panel>
                                    </x-base.dialog>
                                </x-base.table.td>
                            </x-base.table.tr>
                        @empty
                            <x-base.table.tr>
                                <x-base.table.td colspan="6" class="py-12 text-center border-b border-slate-200">
                                    <div class="flex flex-col items-center justify-center">
                                        <x-base.lucide class="w-16 h-16 text-slate-300 mb-4" icon="Building2" />
                                        <h3 class="text-lg font-medium text-slate-600 mb-2">Tidak ada data CV</h3>
                                        <p class="text-slate-500 mb-4">Belum ada CV yang terdaftar dalam sistem</p>
                                        <a href="{{ route($route . '.create') }}">
                                            <x-base.button variant="primary" class="mt-2">
                                                <x-base.lucide class="w-4 h-4 mr-2" icon="Plus" />
                                                Tambah CV Pertama
                                            </x-base.button>
                                        </a>
                                    </div>
                                </x-base.table.td>
                            </x-base.table.tr>
                        @endforelse
                    </x-base.table.tbody>
                </x-base.table>
            </div>
        </div>

        <!-- Pagination -->
        @if($data->hasPages())
        <div class="intro-y col-span-12 mt-6">
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-slate-600 text-sm">
                        Menampilkan {{ $data->firstItem() ?? 0 }} hingga {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} entri
                    </div>
                    <div class="flex items-center">
                        <x-base.pagination.base :data="$data" class="pagination-modern"></x-base.pagination.base>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('scripts')
        <script>
            (function () {
                "use strict";
                
                // Live search functionality
                let searchTimeout;
                const searchInput = document.getElementById('search');
                
                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            const searchValue = this.value;
                            const url = new URL(window.location.href);
                            
                            if (searchValue.trim()) {
                                url.searchParams.set('search', searchValue);
                            } else {
                                url.searchParams.delete('search');
                            }
                            
                            window.location.href = url.toString();
                        }, 500);
                    });
                }
                
                // Auto dismiss alerts after 5 seconds
                setTimeout(() => {
                    const alerts = document.querySelectorAll('[data-dismissible]');
                    alerts.forEach(alert => {
                        if (alert.querySelector('.btn-close')) {
                            alert.querySelector('.btn-close').click();
                        }
                    });
                }, 5000);
                
            })();
        </script>
    @endpush
@endsection
