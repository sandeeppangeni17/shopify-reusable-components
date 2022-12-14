@extends('shopify-app::layouts.default')

@php
if(isset($dashboardsettings)){
$dashboardsetting = $dashboardsettings[0]->setting;
$dashboardsetting = json_decode($dashboardsetting);
if(!empty($dashboardsetting)){
if (array_key_exists("enable_disable_status", $dashboardsetting)){
$enable_disable_status = $dashboardsetting->enable_disable_status;
}
}
}
if(!isset($enable_disable_status)){
$enable_disable_status = 'disabled';
}
@endphp

@section('content')
<link
  rel="stylesheet"
  href="https://unpkg.com/@shopify/polaris@10.15.0/build/esm/styles.css"
/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js" integrity="sha512-tWHlutFnuG0C6nQRlpvrEhE4QpkG1nn2MOUMWmUeRePl4e3Aki0VB6W1v3oLjFtd0hVOtRQ9PHpSfN6u6/QXkQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- You are: (shop domain name) -->
    <!-- <p>You are: {{ $shopDomain ?? Auth::user()->name }}</p> -->
    <div class="Polaris-Page">

    <div class="Polaris-Card">
        <div class="Polaris-Card__Section">            

            <form name="form" id="review_app-config">
                <input type="hidden" name="storeName" value="">
                <!-- Option to enable the app      -->
                <div class="enable-option">
                    <div class="Polaris-Layout__Section--primary enable-option-full margin-right-0">
                        <div
                            style="--top-bar-background:#00848e; --top-bar-color:#f9fafb; --top-bar-background-lighter:#1d9ba4;">
                            <div class="Polaris-Card">
                                <div class="Polaris-Card__Section">
                                    <div class="Polaris-SettingAction check-activation-new ">
                                        <div class="Polaris-SettingAction__Setting app-status-info">Apps is
                                            <strong class="status_brief">{{$enable_disable_status ?? 'disabled'}}</strong>
                                            on your storefront.
                                        </div>
                                        <div class="Polaris-SettingAction__Action enable-size-swap-button">
                                            <button type="button"
                                                class="Polaris-Button enable-btn Polaris-Button--primary {{$enable_disable_status == "disabled" ? "isdisabled" : "isenabled"}}"
                                                value="{{$enable_disable_status ?? 'disabled'}}" id="enable_disable_btn">
                                                <span class="Polaris-Button__Content">
                                                    <span
                                                        class="Polaris-Button__Text">{{$enable_disable_status == "disabled" ? "Enable" : "Disable"}}</span>
                                                </span>
                                            </button>
                                            <input type="hidden" value="off" name="enable_sizeswatch" id="enable-sizeswap">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        actions.TitleBar.create(app, { title: 'Welcome' });

        $('#enable_disable_btn').click(function() {

        var enable_disable_status = $('#enable_disable_btn').val();

        if (enable_disable_status == 'enabled') {
            $('#enable_disable_btn').val("disabled");

        } else if (enable_disable_status == 'disabled') {
            $('#enable_disable_btn').val("enabled");

        }

        var enable_disable_status = $('#enable_disable_btn').val();

        $.ajax({
            type: 'post',
            url: '/updatedata',
            data: {
                enable_disable_status: enable_disable_status
            },
            beforeSend: function(data) {
                console.log(data);
                if (enable_disable_status == 'enabled') {
                    $('#enable_disable_btn').text('Enabling...');
                } else if (enable_disable_status == 'disabled') {
                    $('#enable_disable_btn').text('Disabling...');
                }
            },
            success: function(res) {
                console.log("Response: " + res);
                // location.reload();
                $('.status_brief').text(enable_disable_status);
                if (enable_disable_status == 'enabled') {
                    $('#enable_disable_btn').text('Disable');
                    $('#enable_disable_btn').removeClass('isdisabled');
                    $('#enable_disable_btn').addClass('isenabled');

                    const toastNotice = Toast.create(app, {
                        message: 'App enabled on storefront successfully.',
                        duration: 2500
                    });
                    toastNotice.dispatch(Toast.Action.SHOW);
                } else if (enable_disable_status == 'disabled') {
                    $('#enable_disable_btn').text('Enable');
                    $('#enable_disable_btn').removeClass('isenabled');
                    $('#enable_disable_btn').addClass("isdisabled");

                    const toastNotice = Toast.create(app, {
                        message: 'App disabled on storefront successfully.',
                        duration: 2500
                    });
                    toastNotice.dispatch(Toast.Action.SHOW);
                }
            },
            complete: function() {
                // Handle the complete event
            },
            error: function(err) {
                console.log(err);
            }
        });
    });
    </script>
@endsection