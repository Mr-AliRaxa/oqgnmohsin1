<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold text-white mb-0">
                {{ __('Edit SMTP Configuration') }}
            </h2>
            <a href="{{ route('company.settings.smtp_settings.index') }}" class="btn btn-light btn-sm px-3 shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form action="{{ route('company.settings.smtp_settings.update', $smtpSetting) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- SMTP Host -->
                        <div class="col-md-6">
                            <label for="host" class="form-label fw-bold">SMTP Host <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('host') is-invalid @enderror" id="host" name="host" value="{{ old('host', $smtpSetting->host) }}" placeholder="smtp.gmail.com" required>
                            @error('host')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Example: smtp.gmail.com, smtp.office365.com</small>
                        </div>

                        <!-- SMTP Port -->
                        <div class="col-md-6">
                            <label for="port" class="form-label fw-bold">SMTP Port <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('port') is-invalid @enderror" id="port" name="port" value="{{ old('port', $smtpSetting->port) }}" required>
                            @error('port')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Common: 587 (TLS), 465 (SSL), 25 (No encryption)</small>
                        </div>

                        <!-- Username -->
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $smtpSetting->username) }}" placeholder="your-email@example.com" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Leave blank to keep current password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Leave blank to keep existing password</small>
                        </div>

                        <!-- Encryption -->
                        <div class="col-md-6">
                            <label for="encryption" class="form-label fw-bold">Encryption <span class="text-danger">*</span></label>
                            <select class="form-select @error('encryption') is-invalid @enderror" id="encryption" name="encryption" required>
                                <option value="tls" {{ old('encryption', $smtpSetting->encryption ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ old('encryption', $smtpSetting->encryption) == 'ssl' ? 'selected' : '' }}>SSL</option>
                                <option value="none" {{ old('encryption', $smtpSetting->encryption) === null ? 'selected' : '' }}>None</option>
                            </select>
                            @error('encryption')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- From Address -->
                        <div class="col-md-6">
                            <label for="from_address" class="form-label fw-bold">From Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('from_address') is-invalid @enderror" id="from_address" name="from_address" value="{{ old('from_address', $smtpSetting->from_address) }}" placeholder="noreply@example.com" required>
                            @error('from_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- From Name -->
                        <div class="col-md-6">
                            <label for="from_name" class="form-label fw-bold">From Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('from_name') is-invalid @enderror" id="from_name" name="from_name" value="{{ old('from_name', $smtpSetting->from_name) }}" required>
                            @error('from_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div class="col-md-6">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $smtpSetting->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="is_active">
                                    Set as Active Configuration
                                </label>
                                <small class="d-block text-muted">Only one SMTP configuration can be active at a time</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Update Configuration
                        </button>
                        <a href="{{ route('company.settings.smtp_settings.index') }}" class="btn btn-secondary px-4">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
