<?php
/*
 * @author Vadim Sannikov <vsj.vadim@gmail.com>
 */
namespace Builder;

class Database
{
    public function getData(): iterable {
        return [
            'INSERT name = "A" INTO products',
            'INSERT name = "B" INTO products',
            'INSERT name = "B" INTO products',
        ];
    }
}
