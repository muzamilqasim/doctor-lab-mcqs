@php
    $customCaptcha = loadCustomCaptcha();
@endphp

@if($customCaptcha)
    <div class="contact-form-group contact-form-group mb-2">
        <div class="mb-2">
            @php echo $customCaptcha @endphp
        </div>
        <label class="form-label">Captcha</label>
        <input type="text" name="captcha" placeholder="Captcha" class="form-control" required>
    </div>
@endif