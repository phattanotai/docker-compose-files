<?php
error_reporting( 0 );
use trueWallet\Voucher;
require( 'src/Voucher.php' );

$body = json_decode( file_get_contents( 'php://input' ), true );
if ( isset( $body ) ) {
    $number = $body[ 'number' ];
    $link = $body[ 'link' ];
    $action = $body[ 'action' ];
} else {
    $number = $_POST[ 'number' ];
    $link = $_POST[ 'link' ];
    $action = $_POST[ 'action' ];
}

// 'https://gift.truemoney.com/campaign/?v=yGIDVpsqsbFV1LQSMH'
$voucher = new Voucher( $number, $link );
$return[ 'status' ] = 300;
$return[ 'message' ]   = 'Error';
$return[ 'code' ]   = 'Error';
$return[ 'action' ]   = $action;
if ( $action == 'verify' ) {
    $res = $voucher->verify();
    $json = json_decode( $res );
    if ( $json ) {
        $return[ 'message' ] = $json->status->message;
        $return[ 'code' ] = $json->status->code;
        $return[ 'data' ] = $json->data ;
        if ( $return[ 'message' ] == 'success' ) {
            $return[ 'status' ] = '200';
        } else {
            $return[ 'status' ] = '300';
        }
        die( json_encode( $return ) );
    } else {
        $return[ 'message' ] = 'True Wallet Error: '. scrape( $res );
        die( json_encode( $return ) );
    }
} else if ( $action == 'redeem' ) {
    $res = $voucher->redeem();
    $json = json_decode( $res );
    if ( $json ) {
        $return[ 'message' ] = $json->status->message;
        $return[ 'code' ] = $json->status->code;
        $return[ 'data' ] = $json->data ;
        if ( $return[ 'message' ] == 'success' ) {
            $return[ 'status' ] = '200';
        } else {
            $return[ 'status' ] = '300';
        }
        die( json_encode( $return ) );
    } else {
        $return[ 'message' ] = 'True Wallet Error: '. scrape( $res );
        die( json_encode( $return ) );
    }
}

function setData($action,$json){
    $data = array(
        'amount' => $json->data->voucher->amount_baht,
        'redeemed_amount' => $json->data->voucher->redeemed_amount_baht,
        'voucher_status' => $json->data->voucher->status,
        'voucher_id' => $json->data->voucher->voucher_id,
        'voucher_link' => $json->data->voucher->link,
        'voucher_detail' => $json->data->voucher->detail,
        'expire_date' => date( 'Y/m/d H:i:s', $json->data->voucher->expire_date / 1000 ),
        'name' => $json->data->owner_profile->full_name,
        'mobile_number' => $json->data->redeemer_profile->mobile_number,
        'available' => $json->data->voucher->available,
        'redeemed' => $json->data->voucher->redeemed
    );

    if($action == 'redeem'){
      
    }
    return json_encode($data);
}

function scrape( $result ) {
    $dom = new DOMDocument();
    $dom->loadHTML( $result );
    $element = $dom->getElementsByTagName( 'h1' );
    return  $element[ 0 ]->nodeValue;
}