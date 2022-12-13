@extends('shopify-app::layouts.default')

@section('content')
<link
  rel="stylesheet"
  href="https://unpkg.com/@shopify/polaris@10.15.0/build/esm/styles.css"
/>
    <!-- You are: (shop domain name) -->
    <!-- <p>You are: {{ $shopDomain ?? Auth::user()->name }}</p> -->
    <div class="Polaris-Page">

    <div class="Polaris-Card">
        <div class="Polaris-Card__Section">
            <div class="Polaris-SettingAction">
            <div class="Polaris-SettingAction__Setting">
                <label for="PolarisSettingToggle1">CLick on the button to enable the app on the store <!-- -->
                <span class="Polaris-Text--root Polaris-Text--bodyMd Polaris-Text--bold">deactivated</span>.</label>
            </div>
            <div class="Polaris-SettingAction__Action">
                <button id="PolarisSettingToggle1" class="Polaris-Button Polaris-Button--primary" role="switch" type="button" aria-checked="false">
                <span class="Polaris-Button__Content">
                    <span class="Polaris-Button__Text">Activate</span>
                </span>
                </button>
            </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        actions.TitleBar.create(app, { title: 'Welcome' });
    </script>
@endsection