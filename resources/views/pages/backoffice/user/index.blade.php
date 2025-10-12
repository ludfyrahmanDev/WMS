@extends('../../../layouts/' . $layout)

@section('subhead')
    <title>{{ $title }}</title>
@endsection

@section('subcontent')
    <!-- Header Section -->
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-2xl font-bold text-slate-800 mr-auto">{{ $title }}</h2>
        <div class="flex items-center space-x-2">
            <div class="hidden md:flex items-center text-slate-600">
                <x-base.lucide class="w-4 h-4 mr-2" icon="Users" />
                <span class="text-sm">Total: {{ $data->total() }} pengguna</span>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <x-base.alert class="mb-4 mt-5 flex items-center bg-success/10 border border-success/20" variant="outline-success">
            <x-base.lucide class="mr-3 h-5 w-5 text-success" icon="CheckCircle" />
            <div class="text-success font-medium">{{ session('success') }}</div>
            <x-base.alert.dismiss-button class="btn-close ml-auto" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif
    @if (session('failed'))
        <x-base.alert class="mb-4 mt-5 flex items-center bg-danger/10 border border-danger/20" variant="outline-danger">
            <x-base.lucide class="mr-3 h-5 w-5 text-danger" icon="AlertTriangle" />
            <div class="text-danger font-medium">{{ session('failed') }}</div>
            <x-base.alert.dismiss-button class="btn-close ml-auto" type="button" aria-label="Close">
                <x-base.lucide class="h-4 w-4" icon="X" />
            </x-base.alert.dismiss-button>
        </x-base.alert>
    @endif

    <!-- Action Bar -->
    <div class="intro-y bg-white rounded-lg shadow-sm border border-slate-200 p-5 mt-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <a href="{{ route($route . '.create') }}">
                    <x-base.button class="shadow-md bg-primary hover:bg-primary/90" variant="primary">
                        <x-base.lucide class="w-4 h-4 mr-2" icon="Plus" />
                        Tambah Pengguna
                    </x-base.button>
                </a>
                
                <x-base.menu class="hidden sm:block">
                    <x-base.menu.button class="!box px-3 py-2 border border-slate-300" as="x-base.button">
                        <x-base.lucide class="w-4 h-4 mr-2" icon="Download" />
                        Export
                        <x-base.lucide class="w-4 h-4 ml-2" icon="ChevronDown" />
                    </x-base.menu.button>
                    <x-base.menu.items class="w-48">
                        <x-base.menu.item>
                            <x-base.lucide class="mr-2 h-4 w-4 text-slate-500" icon="Printer" /> 
                            <span>Print Data</span>
                        </x-base.menu.item>
                        <x-base.menu.item>
                            <x-base.lucide class="mr-2 h-4 w-4 text-slate-500" icon="FileText" /> 
                            <span>Export to Excel</span>
                        </x-base.menu.item>
                        <x-base.menu.item>
                            <x-base.lucide class="mr-2 h-4 w-4 text-slate-500" icon="FileText" /> 
                            <span>Export to PDF</span>
                        </x-base.menu.item>
                    </x-base.menu.items>
                </x-base.menu>
            </div>

            <div class="flex items-center space-x-3">
                <div class="text-slate-500 text-sm hidden lg:block">
                    Showing {{ $data->firstItem() ?? 0 }} to {{ $data->lastItem() ?? 0 }} of {{ $data->total() }} entries
                </div>
                <div class="relative">
                    <x-base.form-input class="!box w-64 pr-10 bg-slate-50 border-slate-300" type="text" id="search"
                        value="{{ request()->get('search') }}" placeholder="Cari pengguna..." />
                    <x-base.lucide class="absolute inset-y-0 right-0 my-auto mr-3 h-4 w-4 text-slate-400" icon="Search" />
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-12 gap-6">

        <!-- Data Table -->
        <div class="intro-y col-span-12 overflow-hidden">
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <x-base.table class="border-spacing-y-[10px] border-separate">
                    <x-base.table.thead>
                        <x-base.table.tr class="bg-slate-50">
                            <x-base.table.th class="border-b-0 py-4 px-6 text-left font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span>No</span>
                                </div>
                            </x-base.table.th>
                            <x-base.table.th class="border-b-0 py-4 px-6 text-left font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center">
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-500" icon="User" />
                                    <span>Nama Pengguna</span>
                                </div>
                            </x-base.table.th>
                            <x-base.table.th class="border-b-0 py-4 px-6 text-left font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center">
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-500" icon="Mail" />
                                    <span>Email</span>
                                </div>
                            </x-base.table.th>
                            <x-base.table.th class="border-b-0 py-4 px-6 text-center font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-500" icon="Users" />
                                    <span>Jenis Kelamin</span>
                                </div>
                            </x-base.table.th>
                            <x-base.table.th class="border-b-0 py-4 px-6 text-center font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-500" icon="Shield" />
                                    <span>Role</span>
                                </div>
                            </x-base.table.th>
                            <x-base.table.th class="border-b-0 py-4 px-6 text-center font-medium text-slate-700 whitespace-nowrap">
                                <div class="flex items-center justify-center">
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-500" icon="Settings" />
                                    <span>Aksi</span>
                                </div>
                            </x-base.table.th>
                        </x-base.table.tr>
                    </x-base.table.thead>
                <x-base.table.tbody>
                    @forelse ($data as $item)
                        <x-base.table.tr class="intro-x hover:bg-slate-50 transition-colors duration-200">
                            <x-base.table.td class="py-4 px-6 border-b border-slate-200 text-slate-600 font-medium">
                                <div class="flex items-center justify-center w-8 h-8 bg-slate-100 rounded-full text-sm">
                                    {{ ($data->currentpage() - 1) * $data->perpage() + $loop->index + 1 }}
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="py-4 px-6 border-b border-slate-200">
                                <div class="flex items-center">
                                    <div class="flex items-center justify-center w-10 h-10 bg-primary/10 text-primary rounded-full mr-3">
                                        {{ strtoupper(substr($item['name'], 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-800">{{ $item['name'] }}</div>
                                        <div class="text-sm text-slate-500">{{ ucfirst($item['gender'] ?? 'N/A') }}</div>
                                    </div>
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="py-4 px-6 border-b border-slate-200">
                                <div class="flex items-center">
                                    <x-base.lucide class="w-4 h-4 mr-2 text-slate-400" icon="Mail" />
                                    <span class="text-slate-700">{{ $item['email'] }}</span>
                                </div>
                            </x-base.table.td>
                            <x-base.table.td class="py-4 px-6 border-b border-slate-200 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                    {{ $item['gender'] === 'Laki-laki' ? 'bg-blue-100 text-blue-800' : 
                                       ($item['gender'] === 'Perempuan' ? 'bg-pink-100 text-pink-800' : 'bg-gray-100 text-gray-800') }}">
                                    <x-base.lucide class="w-3 h-3 mr-1" icon="{{ $item['gender'] === 'Laki-laki' ? 'User' : 'User' }}" />
                                    {{ $item['gender'] ?? 'N/A' }}
                                </span>
                            </x-base.table.td>
                            <x-base.table.td class="py-4 px-6 border-b border-slate-200 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-success/10 text-success">
                                    <x-base.lucide class="w-3 h-3 mr-1" icon="Shield" />
                                    {{ $item->role->display_name ?? 'N/A' }}
                                </span>
                            </x-base.table.td>
                            <x-base.table.td class="py-4 px-6 border-b border-slate-200">
                                <div class="flex items-center justify-center space-x-2">
                                    <x-base.button 
                                        class="px-3 py-2 text-xs bg-warning/10 text-warning hover:bg-warning/20 border border-warning/20" 
                                        data-tw-toggle="modal" data-tw-target="#change-role-modal-{{ $item->id }}"
                                        variant="outline-warning">
                                        <x-base.lucide class="w-3 h-3 mr-1" icon="Shield" />
                                        Role
                                    </x-base.button>
                                    <a href="{{ route('users.edit', $item->id) }}">
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
                            </x-base.table.td>
                        </x-base.table.tr>
                    @empty
                        <x-base.table.tr>
                            <x-base.table.td colspan="6" class="py-12 text-center border-b border-slate-200">
                                <div class="flex flex-col items-center justify-center">
                                    <x-base.lucide class="w-16 h-16 text-slate-300 mb-4" icon="Users" />
                                    <h3 class="text-lg font-medium text-slate-600 mb-2">Tidak ada data pengguna</h3>
                                    <p class="text-slate-500 mb-4">Belum ada pengguna yang terdaftar dalam sistem</p>
                                    <a href="{{ route($route . '.create') }}">
                                        <x-base.button variant="primary" class="mt-2">
                                            <x-base.lucide class="w-4 h-4 mr-2" icon="Plus" />
                                            Tambah Pengguna Pertama
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
    <!-- BEGIN: Delete Confirmation Modal -->
    <x-base.dialog id="delete-confirmation-modal">
        <x-base.dialog.panel>
            <div class="p-5 text-center">
                <x-base.lucide class="mx-auto mt-3 h-16 w-16 text-danger" icon="XCircle" />
                <div class="mt-5 text-3xl">Are you sure?</div>
                <div class="mt-2 text-slate-500">
                    Do you really want to delete these records? <br />
                    This process cannot be undone.
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
