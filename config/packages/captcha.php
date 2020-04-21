<?php 

if (!class_exists('CaptchaConfiguration')) { return; }

// BotDetect PHP Captcha configuration options
return [
    // Captcha configuration for example form
    'ExampleCaptchaUserRegistration' => [
        'UserInputID' => 'captchaCode',
        'ImageWidth' => 280,
        'ImageHeight' => 60,
    ],
];