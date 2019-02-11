<?php
namespace BugTrap\Helpers;

use GuzzleHttp\Client;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class Logger
{
    protected $client;
    private $config = [];
    public $additionalData = [];
    public $exception;
    public $inputVariables;
    public $segmentVariables;

    public function __construct(array $exception = [])
    {
        $this->client = new Client;

        $this->config['login_key'] = config('bugtrap.login_key', []);
        $this->config['project_key'] = config('bugtrap.project_key', []);
        $this->config['queue_enabled'] = config('bugtrap.queue.enabled', false);
        $this->config['queue_name'] = config('bugtrap.queue.name', null);

        $this->exception = $exception;
    }

    public function addAdditionalData(array $additionalData = [])
    {
        $this->additionalData = $additionalData;

        return $this;
    }

    public function send()
    {
        $this->sendError();
    }

    public function inputVariables($inputVariables){
        $this->inputVariables = implode("<br/>", $inputVariables) . "<br/>";

       // $this->requestVariable = $requestVariable;

        return $this;
    }

    public function segmentVariables($segmentVariables){
        $this->segmentVariables = implode("<br/>", $segmentVariables) . "<br/>";
        return $this;
    }


    private function sendError()
    {
        $this->client->request('POST', base64_decode('aHR0cDovL3BhbHppbmJ1Zzo4ODg4L2FwaS9sb2c='), [
            'headers' => [
                'X-Authorization'      => $this->config['login_key']
            ],
            'form_params' => [
                'project' => $this->config['project_key'],
                'exception' => $this->exception,
                'additional' => $this->additionalData,
                'segmentparams' => $this->segmentVariables,
                'inputparams' => $this->inputVariables,
                'user' => $this->getUser(),
            ]
        ]);
    }

    /**
     * Get the authenticated user.
     *
     * Supported authentication systems: Laravel, Sentinel
     *
     * @return array|null
     */
    private function getUser()
    {
        if (function_exists('auth') && auth()->check()) {
            return auth()->user()->toArray();
        }

        if (class_exists(\Cartalyst\Sentinel\Sentinel::class) && $user = Sentinel::check()) {
            return $user->toArray();
        }

        return null;
    }
}
