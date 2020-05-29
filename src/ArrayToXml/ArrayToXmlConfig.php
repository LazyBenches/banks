<?php

declare(strict_types=1);

namespace LazyBench\Banks\ArrayToXml;

final class ArrayToXmlConfig
{
    private const DEFAULTS = [
        'version' => '1.0',
        'encoding' => 'UTF-8',
        'attributesKey' => '@ATTRIBUTES',
        'cdataKey' => '@CDATA',
        'valueKey' => '@VALUE',
        'formatOutput' => false,
    ];

    /**
     * Author:LazyBench
     *
     * @var string
     */
    private $version;

    /**
     * Author:LazyBench
     *
     * @var string
     */
    private $encoding;

    /**
     * Author:LazyBench
     *
     * @var string
     */
    private $attributesKey;

    /**
     * Author:LazyBench
     *
     * @var string
     */
    private $cdataKey;

    /**
     * Author:LazyBench
     *
     * @var string
     */
    private $valueKey;

    /**
     * Author:LazyBench
     *
     * @var bool
     */
    private $formatOutput;

    /**
     * ArrayToXmlConfig constructor.
     * @param string $version
     * @param string $encoding
     * @param string $attributesKey
     * @param string $cdataKey
     * @param string $valueKey
     * @param bool $formatOutput \
     */
    private function __construct(string $version, string $encoding, string $attributesKey, string $cdataKey, string $valueKey, bool $formatOutput)
    {
        $this->version = $version;
        $this->encoding = $encoding;
        $this->attributesKey = $attributesKey;
        $this->cdataKey = $cdataKey;
        $this->valueKey = $valueKey;
        $this->formatOutput = $formatOutput;
    }

    /**
     * Author:LazyBench
     *
     * @param array $configData
     * @return ArrayToXmlConfig
     */
    public static function fromArray(array $configData = []): self
    {
        $config = array_merge(self::DEFAULTS, $configData);

        return new self($config['version'], $config['encoding'], $config['attributesKey'], $config['cdataKey'], $config['valueKey'], (bool)$config['formatOutput']);
    }

    /**
     * Author:LazyBench
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Author:LazyBench
     *
     * @return string
     */
    public function getEncoding(): string
    {
        return $this->encoding;
    }

    /**
     * Author:LazyBench
     *
     * @return string
     */
    public function getAttributesKey(): string
    {
        return $this->attributesKey;
    }

    /**
     * Author:LazyBench
     *
     * @return string
     */
    public function getCdataKey(): string
    {
        return $this->cdataKey;
    }

    /**
     * Author:LazyBench
     *
     * @return string
     */
    public function getValueKey(): string
    {
        return $this->valueKey;
    }

    /**
     * Author:LazyBench
     *
     * @return bool
     */
    public function isFormatOutput(): bool
    {
        return $this->formatOutput;
    }
}
