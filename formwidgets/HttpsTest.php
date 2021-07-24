<?php

namespace Synder\Redirects\FormWidgets;

use Backend\Classes\FormWidgetBase;


class HttpsTest extends FormWidgetBase
{
    const LOCALE = 'synder.redirects::lang.config.https_test';

    //
    // Object properties
    //

    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'synder-httpstest';


    /**
     * @inheritDoc
     */
    protected function loadAssets()
    {
        $this->addCss('css/httpstest.css', 'core');
        $this->addJs('js/httpstest.js', 'core');
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return $this->makePartial('field_httpstest');
    }

    /**
     * cURL Wrapper
     *
     * @param string $url
     * @return array
     */
    protected function cUrlWrapper($url, $follow = false)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            \CURLOPT_URL                => $url,
            \CURLOPT_RETURNTRANSFER     => true,
            \CURLOPT_HEADER             => true,
            \CURLOPT_NOBODY             => true,
            \CURLOPT_SSL_VERIFYHOST     => false,
            \CURLOPT_SSL_VERIFYPEER     => false,
            \CURLOPT_FOLLOWLOCATION     => $follow,
            \CURLOPT_CONNECTTIMEOUT     => 5,
            \CURLOPT_TIMEOUT            => 5,
            \CURLOPT_MAXREDIRS          => $follow? 3: 0
        ]);
        curl_exec($curl);
        $status = curl_getinfo($curl, \CURLINFO_RESPONSE_CODE);
        $location = curl_getinfo($curl, $follow? \CURLINFO_EFFECTIVE_URL: \CURLINFO_REDIRECT_URL);
        curl_close($curl);
        
        return [$status, $location];
    }

    /**
     * Testing Process - Step 1 Requirements
     *
     * @return array
     */
    public function onTest_Step1()
    {
        $result = function_exists('curl_version') && in_array('curl', get_loaded_extensions());
        return [
            'result' => $result,
            'resultText' => trans(self::LOCALE . ($result? '.test1_success': '.test1_error'))
        ];

        
    }

    /**
     * Testing Process - Step 2 HTTPS availability
     *
     * @return array
     */
    public function onTest_Step2()
    {
        [$status, $location] = $this->cUrlWrapper(url('/'), true); 
        $result = $status === 200 && strpos($location, 'https:') === 0;

        return [
            'result' => $result,
            'resultText' => trans(self::LOCALE . ($result? '.test2_success': '.test2_error'))
        ];
    }

    /**
     * Testing Process - Step HTTPS redirection
     *
     * @return array
     */
    public function onTest_Step3()
    {
        if (post('Settings')['https_force'] === '0') {
            return [
                'result' => true,
                'resultText' => trans(self::LOCALE . '.test3_canceled')
            ];
        }

        $expect = post('Settings')['https_status_code'];

        [$status, $location] = $this->cUrlWrapper(str_replace('https', 'http', url('/')), false); 
        $result = $status === intval($expect) && strpos($location, 'https:') === 0;

        return [
            'result' => $result,
            'resultText' => trans(self::LOCALE . ($result? '.test3_success': '.test3_error'))
        ];
    }

    /**
     * Testing Process - Step WWW redirection
     *
     * @return array
     */
    public function onTest_Step4()
    {
        if (post('Settings')['www_force'] === '0') {
            return [
                'result' => true,
                'resultText' => trans(self::LOCALE . '.test4_canceled')
            ];
        }

        // Format Base URL
        $url  = 'http' . (post('Settings')['https_force'] === '0'? '': 's') . '://';
        $url .= post('Settings')['www_mode'] === '0'? '': 'www.';
        $url .= preg_replace("#https?:\/\/(www\.)?#", "", url('/'));

        // Check Status
        $expectStatus = post('Settings')['www_status_code'];

        [$status, $_] = $this->cUrlWrapper($url, false); 
        $resultStatus = $status === intval($expectStatus);

        // Check Location
        $expectLocation = post('Settings')['www_mode'] === '0'? '://www.': '://';
        $expectLocation .= str_replace('www.', '', parse_url($url, \PHP_URL_HOST));

        [$_, $location] = $this->cUrlWrapper($url, true); 
        $resultLocation = strpos($location, $expectLocation) !== false;

        // Return Result
        $result = $resultStatus && $resultLocation;
        return [
            'result' => $result,
            'resultText' => trans(self::LOCALE . ($result? '.test4_success': '.test4_error'))
        ];
    }
}
