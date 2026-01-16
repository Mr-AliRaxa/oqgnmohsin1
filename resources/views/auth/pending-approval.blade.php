<x-guest-layout>
    <div class="text-center py-4">
        <div class="mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-clock-history text-warning" viewBox="0 0 16 16">
                <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.74l.824-.568c.19.276.364.563.522.86l-.907.448zm1.025 1.054c-.176-.201-.366-.39-.567-.567l.67-.742c.261.235.508.49.742.75l-.745.659zm.71 1.37c-.143-.366-.256-.743-.342-1.126l.976-.219c.142.365.256.742.342 1.126l-.976.219zM15 8c0 .38-.03.754-.087 1.122l.983.164A8.005 8.005 0 0 0 16 8h-1zM8 15a7 7 0 1 1 0-14 7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M7.5 3a.5.5 0 0 0-.5.5v5.21l3.248 1.856a.5.5 0 0 0 .496-.868L8 7.21V3.5a.5.5 0 0 0-.5-.5z"/>
            </svg>
        </div>

        <h3 class="fw-bold mb-3">Registration Pending</h3>
        <p class="text-secondary mb-4">
            Thank you for registering your company! Your request has been sent to our Super Admin for review. 
            You will be able to access your dashboard once your account is approved.
        </p>

        <div class="bg-light p-3 rounded mb-4 text-start small">
            <p class="mb-1"><strong>What happens next?</strong></p>
            <ul class="mb-0 ps-3">
                <li>Administrators will verify your CR Number and details.</li>
                <li>You will receive an email confirmation once approved.</li>
                <li>This usually takes 1-2 business days.</li>
            </ul>
        </div>

        <div class="d-grid">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary w-100">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
