<!-- BEGIN: Top Bar -->
<div class="relative z-[51] flex h-[67px] items-center border-b border-slate-200">
    <!-- BEGIN: Breadcrumb -->
    <x-base.breadcrumb class="-intro-x mr-auto hidden sm:flex">
        <x-base.breadcrumb.link :index="0">Application</x-base.breadcrumb.link>
        <x-base.breadcrumb.link
            :index="1"
            :active="true"
        >
            Dashboard
        </x-base.breadcrumb.link>
    </x-base.breadcrumb>
    <!-- END: Breadcrumb -->
    @php
        // Check if user has company access
        $hasCompanyAccess = auth()->user() && auth()->user()->hasCompanyAccess();
        
        if($hasCompanyAccess) {
            $cvs = auth()->user()->getAccessibleCVs();
            // set first cv as selected
            $selectedCv = $cvs->first();
            
            // if(request()->has('cv_id')){
            //     session(['cv_id' => request()->get('cv_id')]);
            // }
            $cv_id = session('cv_id');
            // if($selectedCv && !$cv_id){
            //     // share selected cv to all views
            //     session(['cv_id' => $selectedCv->id]);
            // }
        }
    @endphp
    <!-- BEGIN: Company Selector / User Info -->
    <div class="intro-x relative mr-3 sm:mr-6">
        @if($hasCompanyAccess && $cvs->count() > 0)
            <!-- Company/CV Selector -->
            <div class="relative hidden sm:block">
                <div class="flex items-center space-x-2">
                    <x-base.form-select
                        formSelectSize="sm"
                        class="form-control w-48 box pr-10"
                        placeholder="Select Company..."
                        id="select-cv"
                    >
                        @foreach ($cvs as $cv)
                            <option value="{{ $cv->id }}" {{ $cv->id == $cv_id ? 'selected' : '' }}>{{ $cv->name }}</option>
                        @endforeach
                    </x-base.form-select>
                    @if(auth()->user()->getCompanyAccessLevel() === 'limited')
                        <span class="text-xs text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-900/30 px-2 py-1 rounded-full whitespace-nowrap">
                            {{ $cvs->count() }} CV{{ $cvs->count() > 1 ? 's' : '' }}
                        </span>
                    @else
                        <span class="text-xs text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/30 px-2 py-1 rounded-full whitespace-nowrap">
                            All Access
                        </span>
                    @endif
                </div>
            </div>
            <div class="sm:hidden">
                <x-base.lucide
                    class="h-5 w-5 text-slate-600 dark:text-slate-500"
                    icon="Building"
                />
            </div>
        @elseif($hasCompanyAccess && $cvs->count() === 0)
            <!-- No CVs Available -->
            <div class="flex items-center text-slate-600 dark:text-slate-400">
                <div class="hidden sm:block">
                    <div class="flex items-center bg-yellow-50 dark:bg-yellow-900/20 rounded-lg px-3 py-2 border border-yellow-200 dark:border-yellow-800">
                        <x-base.lucide class="h-4 w-4 mr-2 text-yellow-600 dark:text-yellow-400" icon="AlertCircle" />
                        <span class="text-sm font-medium text-yellow-800 dark:text-yellow-200">No companies assigned</span>
                    </div>
                </div>
                <div class="sm:hidden">
                    <x-base.lucide
                        class="h-5 w-5 text-yellow-600 dark:text-yellow-400"
                        icon="AlertCircle"
                    />
                </div>
            </div>
        @else
            <!-- User Info Display -->
            <div class="flex items-center text-slate-700 dark:text-slate-300">
                <div class="hidden sm:block">
                    <div class="flex items-center bg-slate-100 dark:bg-slate-800 rounded-lg px-3 py-2">
                        <x-base.lucide class="h-4 w-4 mr-2 text-slate-500" icon="User" />
                        <span class="text-sm font-medium">{{ auth()->user()->name ?? 'User' }}</span>
                        @if(!$hasCompanyAccess)
                            <span class="ml-2 text-xs text-slate-500 bg-slate-200 dark:bg-slate-700 px-2 py-0.5 rounded-full">
                                Limited Access
                            </span>
                        @endif
                    </div>
                </div>
                <div class="sm:hidden">
                    <x-base.lucide
                        class="h-5 w-5 text-slate-600 dark:text-slate-500"
                        icon="User"
                    />
                </div>
            </div>
        @endif
        <x-base.transition
            class="search-result absolute right-0 z-10 mt-[3px] hidden"
            selector=".show"
            enter="transition-all ease-linear duration-150"
            enterFrom="mt-5 invisible opacity-0 translate-y-1"
            enterTo="mt-[3px] visible opacity-100 translate-y-0"
            leave="transition-all ease-linear duration-150"
            leaveFrom="mt-[3px] visible opacity-100 translate-y-0"
            leaveTo="mt-5 invisible opacity-0 translate-y-1"
        >
            <div class="box w-[450px] p-5">
                <div class="mb-2 font-medium">Pages</div>
                <div class="mb-5">
                    <a
                        class="flex items-center"
                        href=""
                    >
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-success/20 text-success dark:bg-success/10">
                            <x-base.lucide
                                class="h-4 w-4"
                                icon="Inbox"
                            />
                        </div>
                        <div class="ml-3">Mail Settings</div>
                    </a>
                    <a
                        class="mt-2 flex items-center"
                        href=""
                    >
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-pending/10 text-pending">
                            <x-base.lucide
                                class="h-4 w-4"
                                icon="Users"
                            />
                        </div>
                        <div class="ml-3">Users & Permissions</div>
                    </a>
                    <a
                        class="mt-2 flex items-center"
                        href=""
                    >
                        <div
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 text-primary/80 dark:bg-primary/20">
                            <x-base.lucide
                                class="h-4 w-4"
                                icon="CreditCard"
                            />
                        </div>
                        <div class="ml-3">Transactions Report</div>
                    </a>
                </div>
                <div class="mb-2 font-medium">Users</div>
                <div class="mb-5">
                    @foreach (array_slice($fakers, 0, 4) as $faker)
                        <a
                            class="mt-2 flex items-center"
                            href=""
                        >
                            <div class="image-fit h-8 w-8">
                                <img
                                    class="rounded-full"
                                    src="{{ Vite::asset($faker['photos'][0]) }}"
                                    alt="Midone Tailwind HTML Admin Template"
                                />
                            </div>
                            <div class="ml-3">{{ $faker['users'][0]['name'] }}</div>
                            <div class="ml-auto w-48 truncate text-right text-xs text-slate-500">
                                {{ $faker['users'][0]['email'] }}
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mb-2 font-medium">Products</div>
                @foreach (array_slice($fakers, 0, 4) as $faker)
                    <a
                        class="mt-2 flex items-center"
                        href=""
                    >
                        <div class="image-fit h-8 w-8">
                            <img
                                class="rounded-full"
                                src="{{ Vite::asset($faker['images'][0]) }}"
                                alt="Midone Tailwind HTML Admin Template"
                            />
                        </div>
                        <div class="ml-3">{{ $faker['products'][0]['name'] }}</div>
                        <div class="ml-auto w-48 truncate text-right text-xs text-slate-500">
                            {{ $faker['products'][0]['category'] }}
                        </div>
                    </a>
                @endforeach
            </div>
        </x-base.transition>
    </div>
    <!-- END: Company Selector / User Info -->
    <!-- BEGIN: Account Menu -->
    <x-base.menu>
        <x-base.menu.button class="image-fit zoom-in intro-x block h-8 w-8 overflow-hidden rounded-full shadow-lg">
            @if(auth()->user() && auth()->user()->photo)
                <img
                    src="{{ auth()->user()->photo_url }}"
                    alt="{{ auth()->user()->name }}"
                />
            @else
                <div class="bg-primary flex items-center justify-center h-full w-full text-white text-sm font-medium">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
            @endif
        </x-base.menu.button>
        <x-base.menu.items class="mt-px w-56 bg-primary text-white">
            <x-base.menu.header class="font-normal">
                <div class="font-medium">{{ auth()->user()->name ?? 'User' }}</div>
                @if(auth()->user()->role)
                    <div class="text-xs text-white/70 mt-0.5">{{ auth()->user()->role->display_name }}</div>
                @endif
                @if($hasCompanyAccess)
                    <div class="text-xs text-white/60 mt-0.5 flex items-center">
                        <x-base.lucide class="h-3 w-3 mr-1" icon="Building" />
                        @if(auth()->user()->getCompanyAccessLevel() === 'all')
                            All Companies
                        @elseif(auth()->user()->getCompanyAccessLevel() === 'limited')
                            {{ auth()->user()->getAccessibleCVs()->count() }} Companies
                        @endif
                    </div>
                @endif
            </x-base.menu.header>
            <x-base.menu.divider class="bg-white/[0.08]" />
            {{-- <x-base.menu.item class="hover:bg-white/5" href="{{route('profile')}}">
                <x-base.lucide
                    class="mr-2 h-4 w-4"
                    icon="User"
                /> Profile
            </x-base.menu.item> --}}
            <x-base.menu.item class="hover:bg-white/5">
                <x-base.lucide
                    class="mr-2 h-4 w-4"
                    icon="HelpCircle"
                /> Help
            </x-base.menu.item>
            <x-base.menu.divider class="bg-white/[0.08]" />
            <x-base.menu.item class="hover:bg-white/5" href="{{ route('logout') }}" >
                <x-base.lucide
                    class="mr-2 h-4 w-4"
                    icon="ToggleRight"
                /> Logout
            </x-base.menu.item>
            
        </x-base.menu.items>
    </x-base.menu>
    <!-- END: Account Menu -->
</div>
<!-- END: Top Bar -->
<script>
    // CV selector functionality - only if user has company access
    @if($hasCompanyAccess && $cvs->count() > 0)
        document.addEventListener('DOMContentLoaded', function() {
            const selectCv = document.getElementById('select-cv');
            if(selectCv) {
                selectCv.addEventListener('change', function() {
                    var cvId = this.value;
                    // send ajax request to server to change session
                    fetch('/api/change-cv/' + cvId)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            if(data.status === 'success'){
                                // reload page
                                // location reload add cv_id param
                                window.location.href = window.location.pathname + '?cv_id=' + cvId;
                            }
                        })
                        .catch(error => {
                            console.error('Error changing CV:', error);
                            // Fallback: reload with cv_id parameter
                            window.location.href = window.location.pathname + '?cv_id=' + cvId;
                        });
                });
            }
        });
    @endif
</script>
@once
    @push('scripts')
        @vite('resources/js/components/top-bar/index.js')
    @endpush
@endonce
