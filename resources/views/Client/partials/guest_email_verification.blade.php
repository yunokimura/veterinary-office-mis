@if (session('guest_email_verification') === 'verified')
    <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 mb-4">
        <p class="text-emerald-700 text-sm">✓ Email verified - proceeding with registration.</p>
    </div>
@elseif (session('guest_email_verification') === 'failed')
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
        <p class="text-red-700 text-sm">✗ Email verification failed. Please re-enter some information manually.</p>
    </div>
@elseif (session('guest_email_verification') === '' || session('guest_email_verification') === null)
    @if (session('guest_stored_email'))
        <!-- Email verification shown only when token has reporter_email on file -->
        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-6 mb-6">
            <h3 class="text-emerald-700 font-medium mb-4">Verify Your Email</h3>
            <p class="text-gray-600 text-sm mb-4">We have your email on file as:</p>
            <p class="font-medium text-emerald-800">{{ session('guest_stored_email') }}</p>
            
            <form method="POST" class="mt-4">
                @csrf
                <div class="radio-group mb-4">
                    <label class="radio-item">
                        <input type="radio" name="email_verified" value="yes" class="form-radio">
                        <span>Yes, this is my correct email address</span>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="email_verified" value="no" class="form-radio">
                        <span>No, that's not my email address</span>
                    </label>
                </div>
                <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-emerald-700 transition-colors">
                    Continue to Registration
                </button>
            </form>
        </div>
    @elseif (session('guest_no_email_from_token'))
        <!-- No email was stored in the token - skip verification, still pre-fill -->
        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-6 mb-6">
            <h3 class="text-emerald-700 font-medium mb-4">No Email on File</h3>
            <p class="text-emerald-600 text-sm mb-4">No email address was stored from your missing pet report. 
            The form fields will be pre-filled from your report without email verification.</p>
            <p class="text-emerald-500 text-xs">(You can still complete registration, but email verification is not available for this report.)</p>
        </div>
    @endif
@endif