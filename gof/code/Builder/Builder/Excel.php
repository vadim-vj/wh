<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace Builder\Builder;
use Builder\_classes as Classes;

class Excel implements IBuilder
{
    protected $document;

    public function build(): void {
        $this->document = new Classes\Excel();
    }

    public function processRow(string $row): void {
        $this->document->insertFromText($row);
    }

    public function getDocument(): ?Classes\Excel {
        return $this->document;
    }
}
