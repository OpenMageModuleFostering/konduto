<?php

class Konduto_Score_ScoreController extends Mage_Core_Controller_Front_Action {

    public function webAction() {
        $post = json_decode(file_get_contents("php://input"),true);
        
        define("PRIVATE_KEY", "T01234567890123456789");
        $request = json_decode($post, true);
        $hash = $request["hash"];
        unset($request["hash"]);

        ksort($request);

        $string = http_build_query($request);
        if (Mage::getStoreConfig("scoreoptions/messages/debug")) {
            Mage::log('Webhook Post==>' . $request, NULL, 'konduto.log');
        }
        print_r($post);
        if ($hash === hash_hmac("sha256", $string, PRIVATE_KEY)) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    }

}
