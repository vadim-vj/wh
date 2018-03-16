<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace Builder\Builder;
use Builder\_classes as Classes;

class SQL implements IBuilder
{
    protected $dump;

    public function build(): void {
        $this->dump = new Classes\SQL();
    }

    public function processRow(string $row): void {
        $this->dump->appendRow($row);
    }

    public function getDump(): ?Classes\SQL {
        return $this->dump;
    }
}
