<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Osiset\BasicShopifyAPI\BasicShopifyAPI;
use Osiset\BasicShopifyAPI\Options;
use Osiset\BasicShopifyAPI\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use View;
use DB;
use Mail;
use Log;

class ShopController extends Controller
{
    public function index() {
        $shop = Auth::user();
        $shop_name = Auth::user()->name;

        $dashboardsettings_count = DB::table('dashboard_settings')
        ->where('store', $shop_name)
        ->count();

        $store_domain = $shop_name;

        if($dashboardsettings_count == 1){
            $dashboardsettings = DB::table('dashboard_settings')
            ->where('store', $shop_name)
            ->get();
            return view('welcome', compact('dashboardsettings', 'store_domain'));
        }
        else {
            return view('welcome', compact('store_domain'));
        }
    }

    // save dashboard settings to batabase
    public function savetometafield(Request $req){
    
        $shop_domain = Auth::user()->name;
        $accesstoken = Auth::user()->password;
        // Create options for the API
        $options = new Options();
        $options->setVersion('2022-10');

        // Create the client and session
        $api = new BasicShopifyAPI($options);
        $api->setSession(new Session($shop_domain, $accesstoken));

        $status = $req->enable_disable_status;
        
        $data = $req->all();
        $setting_data = array();
         foreach ($data as $key=>$val) {
            $setting_data[$key] = str_replace(',', ',', $val);
        }
       
        $metafield_data = array(
            'metafield' => array(
                "namespace" => "customapp",
                "key" => "status",
                "value" => $status,
                "type" => "single_line_text_field"
            )
        );

        try
        {
            $status_meta_create = $api->rest('POST', '/admin/metafields.json', $metafield_data);

            $datatodb = json_encode($setting_data);
            $upserttodb = DB::table('dashboard_settings')->upsert([
                ['store' => $shop_domain, 'setting' => $datatodb]           
            ], ['store'], ['setting']);

            // echo $status_meta_create['body']['metafield']['id'];
        }
         catch (shopify\ApiException $e)
        {
            echo json_encode($e);
        }
        catch (shopify\CurlException $e)
        {
            echo json_encode($e);
        }
    }
}
