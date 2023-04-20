<?php
/**
 * Created by PhpStorm.
 * User: Rare
 * Date: 18.04.2023
 * Time: 11:42
 */

namespace app\components;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class TranslationsData
{
    public static $host = 'https://app.vpn-max.com';

    public static function getLanguages()
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        try {
            $request = new Request('GET', self::$host . '/api/translations/languages', $headers, null);
            $res = $client->sendAsync($request)->wait();
            $data = json_decode($res->getBody(), true);
            if (!empty($data['data']) && $data['statusCode'] == 200) {
                $langs = [];
                foreach ($data['data'] as $item) {
                    if (!empty($item['local_id'])) {
                        $expid = explode('_', $item['local_id'])[0] ?? $item['local_id'];
                        $langs[] = $expid;
                    }
                }
                return $langs;
            }
        } catch (\Exception $exception) {
            return ['ru'];
        }
    }

    public static function getTranslations($local)
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        try {
        $request = new Request('GET', self::$host . '/api/translations/web?locale_id=' . $local, $headers, null);
        $res = $client->sendAsync($request)->wait();
        $data = json_decode($res->getBody(), true);
        if (!empty($data['data']) && $data['statusCode'] == 200) {
            $translations = [];
            foreach ($data['data'] as $item) {
                $translations[$item['element_id']] = $item['descriptions'];
            }
            return $translations;
        }
        } catch (\Exception $exception) {
            return [
                'web-menu-menu-1' => 'Features',
                'web-menu-menu-2' => 'FAQ',
                'web-menu-menu-3' => 'Feedback',
                'web-menu-menu-4' => 'Prices',
                'web-home-subtitle-1' => 'Fast and <br> anonymous access<br> to any website',
                'Цены' => 'Prices',
                'web-button-download' => 'Download',
                'web-login-title' => 'Log In',
                'web-button-try-free' => 'Try for free',
                'web-home-subtitle-2' => 'What is VPN MAX',
                'web-home-text-1' => 'Superfast servers all over the world',
                'web-home-text-2' => 'VPN autostart in the background',
                'web-home-text-3' => 'A wide selection of countries',
                'web-home-text-4' => 'Real IP hidden',
                'web-home-text-5' => 'Traffic encrypted',
                'web-home-text-6' => 'Access to any website',
                'web-home-text-7' => 'No logs kept on servers',
                'web-home-text-8' => 'Unlimited traffic',
                'web-home-text-9' => 'days money back guarantee',
                'web-home-text-10' => 'countries to access the Internet',
                'web-home-text-11' => 'devices simultaneously',
                'web-home-text-12' => 'Install the app',
                'web-home-subtitle-3' => 'For any device',
                'web-home-text-13' => 'Sign up',
                'web-home-text-14' => 'Enter the core from the e-mail',
                'web-home-text-15' => 'You will receive the code after paying or requesting a trial period',
                'web-home-text-16' => 'Your IP is now anonymous, and your connection is encrypted',
                'web-home-text-17' => 'Set up a connection',
                'web-home-text-18' => 'Enter the core from the e-mail in the app',
                'web-home-subtitle-4' => 'Three steps to connect to VPN MAX',
                'web-home-text-20' => 'Select a server',
                'web-home-text-21' => 'Automatic selection, or selection based on the website you need',
                'web-home-text-22' => 'Click Connect',
                'web-home-text-23' => 'Download the app',
                'web-home-text-24' => 'Upon installing, open the app <br>
                                    and log in to the system with your <br>
                                    username and password. To get<br>
                                    a VPN MAX account,<br>
                                    sign up here',
                'web-home-text-25' => 'Set up VPN autostart',
                'web-home-text-26' => 'You will not have to turn your VPN on<br>
and off every time you need it. It will run<br>
automatically for the selected apps',
                'web-home-text-27' => 'Now you have an anonymous access to all the resources you need',
                'web-home-text-28' => 'Trial access to VPN for 72 hours',
                'web-home-text-29' => 'By clicking you consent to the processing of your personal data and accept the Privacy Policy',
                'web-home-text-30' => 'What is VPN MAX?',
                'web-home-text-31' => 'Go to the checkout page and select the best tariff for you. We offer 1-month, 1-year, and 2-years options.',
                'web-home-text-32' => 'Why do I need a VPN?',
                'web-home-text-33' => 'How is VPN MAX better than its competitors?',
                'web-home-text-34' => 'My subscription is ending. How do I renew it?',
                'web-home-text-35' => 'How to install VPN MAX?',
                'web-home-text-36' => 'How do I select a server?',
                'web-home-text-37' => 'Do you collect data?',
                'web-home-text-38' => 'Can I use VPN MAX at select websites only?',
                'web-home-text-39' => 'How do I buy VPN MAX?',
                'web-home-text-40' => 'What is the difference between the paid and free VPN MAX?',
                'web-home-text-41' => 'How to subscribe to VPN MAX for more than 2 years?',
                'web-home-text-42' => 'How does the 30-day money back guarantee work?',
                'web-home-text-43' => 'How many devices can I use VPN MAX on simultaneously?',
                'web-home-text-44' => '30 days money back guarantee',
                'web-home-text-45' => 'Best choice',
                'web-home-text-46' => 'month',
                'web-home-text-47' => 'months',
                'web-home-text-48' => 'year',
                'web-home-text-49' => 'Unlimited speed',
                'web-home-text-50' => 'All locations',
                'web-home-text-51' => 'Up to 6 devices',
                'web-home-text-52' => 'Unlimited traffic',
                'web-home-text-53' => 'Total due',
                'web-home-text-54' => 'This amount will be debited monthly',
                'web-home-text-55' => 'By clicking Buy you confirm your acceptance of the recurrent payment offer terms, consent to the processing of your personal data, and accept the Privacy Policy',
                'web-home-text-56' => 'this amount will be debited every 6 months',
                'web-home-text-57' => 'this amount will be debited every 12 months',
                'web-home-text-58' => 'You applied a discount coupon',
                'button-accept' => 'Accept',
                'web-button-logout' => 'Logout',
                'web-profile-button' => 'Profile',
                'web-link-footer-1' => 'Privacy Policy',
                'web-link-footer-2' => 'Terms of Servic',
                'web-link-footer-3' => 'Contact us',
                'web-field-name' => 'Your name',
                'web-button-ask' => 'Ask your question',
                'web-configuration-text-1' => 'We use cookies and other technologies to help keep our site safe and secure. I agree and may withdraw or change my consent at any time with effect for the future.',
            ];
        }

    }

}