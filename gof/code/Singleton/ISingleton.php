<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace Singleton;

interface ISingleton
{
    public const DEFAULT = '#default';
    public static function getInstance(string $id = self::DEFAULT): self;
}
