<?php namespace Rollbar\Payload;

class Trace implements ContentInterface
{
    private $frames;
    private $exception;
    private $utilities;

    public function __construct(array $frames, ExceptionInfo $exception)
    {
        $this->utilities = new \Rollbar\Utilities();
        $this->setFrames($frames);
        $this->setException($exception);
    }

    public function getKey()
    {
        return 'trace';
    }

    public function getFrames()
    {
        return $this->frames;
    }

    public function setFrames(array $frames)
    {
        foreach ($frames as $frame) {
            if (!$frame instanceof Frame) {
                throw new \InvalidArgumentException("\$frames must all be Rollbar\Payload\Frames");
            }
        }
        $this->frames = $frames;
        return $this;
    }

    public function getException()
    {
        return $this->exception;
    }

    public function setException(ExceptionInfo $exception)
    {
        $this->exception = $exception;
        return $this;
    }

    public function jsonSerialize()
    {
        $result = array(
            "frames" => $this->frames,
            "exception" => $this->exception,
        );
        return $this->utilities->serializeForRollbar($result);
    }
}
