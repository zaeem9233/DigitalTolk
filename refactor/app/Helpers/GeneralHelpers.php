<?php 

namespace App\Helper;

class GeneralHelpers{
    public static function checkValueIsEmptyOrNot($value){
        if(isset($value) && $value != ""){
            return $value;
        }else{
            return "";
        }
    }

    public static function checkValueIsTrueOrNot($value){
        if($value == 'true'){
            return 'yes';
        }else{
            return 'no';
        }
    }

    public static function getResponseArrayNotIsset($val1, $val2){
        if(!isset($val1)){
            $response['status'] = 'fail';
            $response['message'] = 'Du måste fylla in alla fält';
            $response['field_name'] = $val2;
            return $response;
        }
        return Null;
    }
    
    public static function getResponseArrayIsset($val1, $val2, $message = 'Du måste fylla in alla fält'){
        if(isset($val1) && $val1 == ''){
            $response['status'] = 'fail';
            $response['message'] = $message;
            $response['field_name'] = $val2;
            return $response;
        }
        return Null;
    }

    public static function checkArraySingle($val1, $val2, $arr){
        if(in_array($val1, $arr)){
            return $val2;
        }
    }

    public static function checkArrayDouble($val1, $val2, $val3, $arr){
        if(in_array($val1, $arr) && in_array($val2, $arr)){
            return $val3;
        }
    } 

    public static function getJobForArray($job){
        $jobForArray = [];
        if ($job->gender != null) {
            $jobForArray[] = self::mapGenderToSwedish($job->gender);
        }
        if ($job->certified != null) {
            $jobForArray[] = self::mapCertifiedToSwedish($job->certified);
        }
        return $jobForArray;
    }

    public static function mapGenderToSwedish($gender)
    {
        return ($gender == 'male') ? 'Man' : (($gender == 'female') ? 'Kvinna' : null);
    }

    public static function getJobFor($certified){
        if ($certified == 'both') {
            return ['normal', 'certified'];
        } else if ($certified == 'yes') {
            return 'certified';
        }
        return $certified;
    }

    private static function mapCertifiedToSwedish($certified)
    {
        $mapping = [
            'both' => ['Godkänd tolk', 'Auktoriserad'],
            'yes' => 'Auktoriserad',
            'n_health' => 'Sjukvårdstolk',
            'law' => 'Rättstolk',
            'n_law' => 'Rättstolk'
        ];

        return $mapping[$certified] ?? $certified;
    }

    public static function getCurlRequest($url, $type, $authKey, $fields){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($type, $authKey));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        return curl_exec($ch);
    }

    public static function getTranslatorType($val1){
        if($val1 == 'paid'){
            return 'professional';
        }elseif($val1 == 'rws'){
            return 'rwstranslator';
        }elseif($val1 == 'unpaid'){
            return 'volunteer';
        }
        return null;
    }

    public static function getConsumerType($val){
        if ($val == 'rwsconsumer')
            return 'rws';
        else if ($val == 'ngo')
            return 'unpaid';
        else if ($val == 'paid')
            return 'paid';
    }

    public static function getTranslatorLevel($job){
        $translator_level = [];
        $certificationMap = [
            'yes' => ['Certified', 'Certified with specialisation in law', 'Certified with specialisation in health care'],
            'law' => ['Certified with specialisation in law'],
            'n_law' => ['Certified with specialisation in law'],
            'health' => ['Certified with specialisation in health care'],
            'n_health' => ['Certified with specialisation in health care'],
            'normal' => ['Layman', 'Read Translation courses'],
            'both' => ['Certified', 'Certified with specialisation in law', 'Certified with specialisation in health care', 'Layman', 'Read Translation courses'],
            null => ['Certified', 'Certified with specialisation in law', 'Certified with specialisation in health care', 'Layman', 'Read Translation courses'],
        ];
        if (!empty($job->certified) && isset($certificationMap[$job->certified])) {
            $translator_level = $certificationMap[$job->certified];
        }

        return $translator_level;
    }

    public static function getUserEmail($job, $user){
        return (!empty($job->user_email)) ? $job->user_email : $user->email; 
    }
}