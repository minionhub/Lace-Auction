@if(\App\Models\Extension::where('act', 'custom-captcha')->where('status', 1)->first())
    <div class="form-group">
        @php echo  getCustomCaptcha(46, '100%') @endphp
    </div>
    <div class="form-group">
        <input type="text" name="captcha" placeholder="@lang('Enter Code')" class="form-controller">
    </div>
@endif
