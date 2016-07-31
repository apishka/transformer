<?php namespace Apishka\Validator;

/**
 * Exception
 *
 * @easy-extend-base
 */

class FriendlyException extends Exception
{
    /**
     * Data
     *
     * @var array
     */

    private $_error_data = null;

    /**
     * Params
     *
     * @var array
     */

    private $_error_params = null;

    /**
     * Traits
     */

    use \Apishka\EasyExtend\Helper\ByClassNameTrait;

    /**
     * Construct
     *
     * @param array $error
     * @param array $params
     */

    public function __construct($error, $params = array())
    {
        $this->_error_data   = $error;
        $this->_error_params = $params;

        parent::__construct(
            $this->renderMessage($error, $params),
            $this->renderCode($error, $params)
        );
    }

    /**
     * Get message class
     *
     * @return array
     */

    public function getErrorData()
    {
        return $this->_error_data;
    }

    /**
     * Get error params
     *
     * @return array
     */

    public function getErrorParams()
    {
        return $this->_error_params;
    }

    /**
     * Get error data message class
     *
     * @return string|null
     */

    public function getErrorDataMessageClass()
    {
        if (array_key_exists('message_class', $this->getErrorParams()))
            return $this->getErrorParams()['message_class'];

        return null;
    }

    /**
     * Render message
     *
     * @param array $error
     * @param array $params
     *
     * @return string
     */

    protected function renderMessage($error, $params)
    {
        $message = $error['message'];

        foreach ($params as $name => $value)
            $message = str_replace('{' . $name . '}', $value, $message);

        return $message;
    }

    /**
     * Render code
     *
     * @param array $error
     * @param array $params
     *
     * @return string
     */

    protected function renderCode($error, $params)
    {
        if (array_key_exists('code', $error))
            return $error['code'];

        return 0;
    }

    /**
     * Call static prepare
     *
     * @param array  $data
     * @param string $name
     * @param array  $arguments
     *
     * @return FriendlyException this
     */

    protected static function __apishka(array $data, $name, array $arguments)
    {
        return new $data['class'](...$arguments);
    }
}
