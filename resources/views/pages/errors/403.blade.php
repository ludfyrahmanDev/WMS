@extends('../layouts/' . 'side-menu')

@section('subhead')
    <title>403 - Access Denied</title>
@endsection

@section('subcontent')
    <div class="container">
        <!-- BEGIN: Error Page -->
        <div class="error-page flex flex-col lg:flex-row justify-center items-center lg:items-start px-5 py-16 sm:px-20 min-h-screen">
            <div class="text-center lg:text-left">
                <div class="mt-10 lg:mt-0">
                    <div class="intro-x text-8xl font-medium text-primary">403</div>
                    <div class="intro-x text-xl lg:text-3xl font-medium mt-5">
                        Halaman Tidak Tersedia
                    </div>
                    <div class="intro-x text-lg mt-3 text-slate-500 dark:text-slate-400">
                        {{ $message ?? 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}
                    </div>
                    @if(isset($missing_permissions) && count($missing_permissions) > 0)
                        <div class="intro-x text-sm mt-3 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                            <p class="text-yellow-800 dark:text-yellow-200 font-medium mb-2">Izin yang diperlukan:</p>
                            <ul class="text-yellow-700 dark:text-yellow-300 text-xs space-y-1">
                                @foreach($missing_permissions as $permission)
                                    <li class="flex items-center">
                                        <x-base.lucide class="w-3 h-3 mr-2" icon="AlertCircle" />
                                        {{ \App\Services\PermissionTranslationService::translate($permission) }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="intro-x text-sm mt-2 text-slate-500 dark:text-slate-400">
                        Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
                    </div>
                </div>
                <div class="intro-x mt-10 flex flex-col lg:flex-row gap-3">
                    <x-base.button 
                        class="py-3 px-4 border-transparent text-white dark:text-slate-300" 
                        variant="primary"
                        onclick="window.history.back()"
                    >
                        <x-base.lucide class="w-4 h-4 mr-2" icon="ArrowLeft" />
                        Kembali
                    </x-base.button>
                    <a href="{{ route('dashboard') }}">
                        <x-base.button 
                            class="py-3 px-4 border-transparent text-slate-900 dark:text-slate-300" 
                            variant="outline-primary"
                        >
                            <x-base.lucide class="w-4 h-4 mr-2" icon="Home" />
                            Ke Dashboard
                        </x-base.button>
                    </a>
                </div>
            </div>
            <div class="lg:ml-20">
                <div class="intro-x">
                    <div class="w-full lg:w-96 flex items-center justify-center bg-slate-100 dark:bg-slate-800 rounded-2xl h-64">
                        <div class="text-center">
                            <x-base.lucide class="w-24 h-24 text-slate-400 mx-auto mb-4" icon="ShieldX" />
                            <p class="text-slate-500 dark:text-slate-400">Akses Terbatas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Error Page -->
    </div>
@endsection
