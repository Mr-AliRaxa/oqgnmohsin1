<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold mb-0">
            {{ __('Global Settings') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('super_admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label for="global_logo" class="form-label fw-bold">System Logo</label>
                            <input id="global_logo" type="file" name="global_logo" class="form-control" />
                            <div id="logoHelp" class="form-text">This logo will be displayed in both Super Admin and Company Admin headers.</div>
                            
                            @if(isset($settings['global_logo']))
                                <div class="mt-3">
                                    <p class="small text-muted mb-1">Current Logo:</p>
                                    <div class="p-2 border rounded bg-light d-inline-block">
                                        <img src="{{ asset('storage/' . $settings['global_logo']) }}" class="h-32 shadow-sm" style="max-height: 100px; width: auto;" alt="Global Logo">
                                    </div>
                                </div>
                            @endif
                            <x-input-error :messages="$errors->get('global_logo')" class="mt-2" />
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save Logo') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
