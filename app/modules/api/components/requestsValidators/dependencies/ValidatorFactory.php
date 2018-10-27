<?php
namespace app\modules\api\components\requestsValidators\dependencies;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;

class ValidatorFactory
{

    private $factory;

    public function __construct()
    {
        $this->factory = new Factory($this->loadTranslator());
    }

    protected function loadTranslator()
    {
        $filesystem = new Filesystem();
        $fileLoader = new FileLoader($filesystem, '');
        $translator = new Translator($fileLoader, 'en_US');

        return $translator;
    }

    public function __call($method, $args)
    {
        return call_user_func_array(
                [$this->factory, $method], $args
        );
    }

    public function make(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        $messages = empty($messages) ? ValidationMessages::defaultErrorMsgs() : array_merge($messages, ValidationMessages::defaultErrorMsgs());
        return $this->factory->make($data, $rules, $messages, $customAttributes);
    }

}
