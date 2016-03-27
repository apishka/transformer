<?php namespace Apishka\Validator;

/**
 * Exception
 *
 *
 * @easy-extend-base
 */

class FriendlyException extends Exception
{
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
        $code = 0;
        if (array_key_exists('code', $error))
            $code = $error['code'];

        parent::__construct(
            $this->renderMessage($error, $params),
            $code
        );
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
