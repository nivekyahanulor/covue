<?php
date_default_timezone_set("Asia/Tokyo");
require_once APPPATH . "libraries/zoho_sdk/vendor/autoload.php";
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\oauth\ZohoOAuth;
use zcrmsdk\crm\crud\ZCRMRecord;
class Zoho_sdk extends MX_Controller
{
    public function get_auth_token()
    {
        $configuration = [
            "client_id" => "1000.5MI5B7BXY8941QOKWCFTK8WHHUZNSA",
            "client_secret" => "e141eff564fca01ad6279ec1a03e964ff2b781d15b",
            "redirect_uri" => "http://localhost/rest/index.php",
            "currentUserEmail" => "ext.org.user.1@covue.com",
        ];
        $a = ZCRMRestClient::initialize($configuration);
        $oAuthClient = ZohoOAuth::getClientInstance();
        $refreshToken =
            "1000.6eeb347421096e81f006317982e5e2ea.aefac94bba2034e9bf67e648acd46526";
        $userIdentifier = "ext.org.user.1@covue.com";
        $oAuthTokens = $oAuthClient->generateAccessTokenFromRefreshToken(
            $refreshToken,
            $userIdentifier
        );
        $arr["refreshToken"] = $refreshToken;
        $arr["userIdentifier"] = $userIdentifier;
        $arr["oAuthTokens"] = $oAuthTokens;
        return $arr;
    }

    public function create_zoho_account_by_sdk( $account_arr, $refreshToken, $userIdentifier) {
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Accounts" );
        $Are_you_an_online_seller =$account_arr["online_seller"] == "1" ? true : false;
        $Client_Type =$account_arr["client_type"] == "2" ? "IOR services" : "Mailing Services";
        $records = [];
        $record = ZCRMRecord::getInstance("Accounts", null);
        $record->setFieldValue("Account_Name", $account_arr["Account_Name"]);
        $record->setFieldValue("Username", $account_arr["Username"]);
        $record->setFieldValue("Address_Line_1",$account_arr["Address_Line_1"] );
        $record->setFieldValue("City", $account_arr["City"]);
        $record->setFieldValue("Country", $account_arr["Country"]);
        $record->setFieldValue("Zip_Code", $account_arr["Zip_Code"]);
        $record->setFieldValue("Contact_Name", $account_arr["Contact_Name"]);
        $record->setFieldValue("Email_1", $account_arr["Email_1"]);
        $record->setFieldValue("Phone", $account_arr["Phone"]);
        $record->setFieldValue("Portal_ID", $account_arr["Portal_ID"]);
        $record->setFieldValue("Client_Type", $Client_Type);
        $record->setFieldValue("Are_you_an_online_seller",$Are_you_an_online_seller);
        $record->setFieldValue( "Business_License_Number",$account_arr["Business_License_Number"]);
        $result = array_push($records, $record);
        $responseIn = $moduleIns->createRecords($records);
        return $responseIn;
    }

  public function create_product_in_zoho_crm($product_arr,$refreshToken,$userIdentifier ) {
        $Product_Active = $product_arr["active"] == "1" ? true : false;
        $moduleIns = ZCRMRestClient::getInstance()->getModuleInstance("Products");
        $records = [];
        $record = ZCRMRecord::getInstance("Products", null);
        $record->setFieldValue("Product_Name", $product_arr["product_name"]);
        $record->setFieldValue("Description", $product_arr["product_name"]);
        $record->setFieldValue("Product_Id1", $product_arr["product_id"]);
        $record->setFieldValue("User_ID", $product_arr["user_id"]);
        $record->setFieldValue("Product_Code", $product_arr["product_code"]);
        $record->setFieldValue("Product_Active", $Product_Active);
        $result = array_push($records, $record);
        $responseIn = $moduleIns->createRecords($records);
        return json_encode($responseIn);
    }
}
?>