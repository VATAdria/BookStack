    <div>
        <a href="{{ route('authorize.login') }}" id="oauth-login" class="button outline svg">
            @icon('vatsim1')
            <!-- <span>{{ trans('auth.log_in_with', ['socialDriver' => config('oidc.name')]) }}</span> -->
            <span> LOGIN WITH SSO</span>
        </a>
    </div>