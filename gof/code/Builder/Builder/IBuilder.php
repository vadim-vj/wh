<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace Builder\Builder;

interface IBuilder
{
    public function build(): void;
    public function processRow(string $row): void;
}
