<?php 

use Carbon\Carbon;
use App\Mail\Email;
use App\Models\User;
use App\Lib\Captcha;
use App\Lib\ClientInfo;
use App\Lib\FileManager;
use App\Models\HomeSetting;
use App\Models\GeneralSetting;
 
function gs() {
    try {
        $general = GeneralSetting::first();
        return $general;
    } catch (\Exception $e) {
        return null;
    }
}

function verifyCaptcha()
{
    return Captcha::verify();
}

function loadCustomCaptcha($width = '100%', $height = 46, $bgColor = '#003')
{
    return Captcha::customCaptcha($width, $height, $bgColor);
}


function urlPath($routeName, $routeParam = null)
{
    if ($routeParam == null) {
        $url = route($routeName);
    } else {
        $url = route($routeName, $routeParam);
    }
    $basePath = route('admin.dashboard.index');
    $path = str_replace($basePath, '', $url);
    return $path;
}

function hs() {
    try {
        $home = HomeSetting::first();
        return $home;
    } catch (\Exception $e) {
        return null;
    }
}

function helloTest() {
    return "Hello Test";
}

function fileUploader($file, $location, $size = null, $old = null, $thumb = null) {
    $fileManager        = new FileManager($file);
    $fileManager->path  = $location;
    $fileManager->size  = $size;
    $fileManager->old   = $old;
    $fileManager->thumb = $thumb;
    $fileManager->upload();
    return $fileManager->filename;
}

function fileManager() {
    return new FileManager();
}

function getFilePath($key) {
    return fileManager()->$key()->path;
}

function getFileSize($key)
{
    return fileManager()->$key()->size;
}

function getImage($image, $size = null) {
    $clean = '';
    if (file_exists($image) && is_file($image)) {
        return asset($image) . $clean;
    }
    return asset('assets/front/images/default.png');
}

function sendEmail($subject, $email, $template, $data = []) 
{
    $general = gs();
    $mailData = [
        'subject' => $subject,
    ];
    $mailData = array_merge($mailData, $data);
    Mail::to($email)->send(new Email($mailData, $template));
}


function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}

function getPaginate($paginate = 8)
{
    return $paginate;
}

function paginationIndex($paginator, $index) {
    return ($paginator->currentPage() - 1) * $paginator->perPage() + $index + 1;
}

function diffForHumans($date)
{
    return Carbon::parse($date)->diffForHumans();
}

function showDate($date, $format = 'd-m-Y')
{
    return Carbon::parse($date)->translatedFormat($format);
}

function menuActive($routeNames, $type = null, $param = null) {
    $class = ($type == 1) ? 'menu-open' : 'active';

    if (!is_array($routeNames)) {
        $routeNames = [$routeNames];
    }

    foreach ($routeNames as $routeName) {
        if (request()->routeIs($routeName)) {
            if ($param) {
                $routeParam = array_values(request()->route()->parameters());
                if (strtolower($routeParam[0]) == strtolower($param)) {
                    return $class;
                } else {
                    continue;
                }
            }
            return $class;
        }
    }
    return '';
}

function getIpInfo()
{
    $ipInfo = ClientInfo::ipInfo();
    return $ipInfo;
}

function osBrowser()
{
    $osBrowser = ClientInfo::osBrowser();
    return $osBrowser;
}

function verificationCode($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = (int) ($min - 1).'9';
    return random_int($min,$max);
}

function getRealIP()
{
    $ip = $_SERVER["REMOTE_ADDR"];
    if (filter_var(@$_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_FORWARDED'];
    }
    if (filter_var(@$_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    if ($ip == '::1') {
        $ip = '127.0.0.1';
    }
    return $ip;
}

if (!function_exists('user')) {
    function user()
    {
        return auth()->user();
    }
}

if (!function_exists('userId')) {
    function userId()
    {
        return auth()->id();
    }
}