<x-layout>
    <div class="bg-login d-flex align-items-center justify-content-center min-vh-100">
        <main class="main-content mt-0 d-flex align-items-center justify-content-center w-100">
            <div class="session d-flex bg-white rounded-4 shadow-sm p-4 border" style="max-width: 420px; width: 100%;">
                <form method="POST" action="{{ route('login') }}" class="log-in w-100" autocomplete="off">
                    @csrf
                    <div class="mb-4 text-center">
                        <h4 class="fw-bold mb-1 text-dark">
                            Portal de <span style="color:#1c2e4a;">Colaboradores</span>
                        </h4>
                        <p class="text-muted small mb-0">Autentica-te para acederes à plataforma</p>
                    </div>

                    <div class="form-floating mb-3 position-relative">
                        <input 
                            type="email" 
                            id="email" 
                            name="email"
                            class="form-control border-0 shadow-sm @error('email') is-invalid @enderror"
                            placeholder="nome@exemplo.com" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                            style="background-color: #f8f9fa;"
                        >
                        <label for="email">Email</label>
                        <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="color: #6c757d;">
                            <i class="bi bi-envelope-fill"></i>
                        </span>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3 position-relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            class="form-control border-0 shadow-sm @error('password') is-invalid @enderror"
                            placeholder="Palavra-passe" 
                            required 
                            autocomplete="current-password"
                            style="background-color: #f8f9fa;"
                        >
                        <label for="password">Palavra-passe</label>
                        <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="color: #6c757d;">
                            <i class="bi bi-lock-fill"></i>
                        </span>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="remember" 
                            name="remember" 
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label class="form-check-label small" for="remember">Manter sessão iniciada</label>
                    </div>

                    <button type="submit" class="btn w-100 rounded-pill mb-3" style="background-color: #1c2e4a; color: #fff; border: none;">
                        Entrar
                    </button>

                    <div class="text-center small text-muted">
                        <p class="mb-1">
                            Ainda não tens conta? 
                            <a href="{{ route('register') }}" class="text-decoration-none" style="color: #1c2e4a;">Registar</a>
                        </p>
                        <p>
                            Esqueceste-te da palavra-passe? 
                            <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #1c2e4a;">Recuperar acesso</a>
                        </p>
                    </div>
                </form>
            </div>
        </main>
    </div>

    @push('js')
        <script>
            document.querySelectorAll('.form-floating input').forEach(input => {
                input.addEventListener('focus', e => e.target.closest('.form-floating').classList.add('focused'));
                input.addEventListener('blur', e => {
                    if (!e.target.value) {
                        e.target.closest('.form-floating').classList.remove('focused');
                    }
                });

                if (input.value) {
                    input.closest('.form-floating').classList.add('focused');
                }
            });
        </script>
    @endpush
</x-layout>
