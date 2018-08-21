<?php

namespace Ifedko\DoctrineDbalPagination;

use Doctrine\DBAL\Connection;
use Ifedko\DoctrineDbalPagination\Exception\ListPaginationFactoryException;

/**
 * Class ListPaginationFactory
 *
 * @package Ifedko\DoctrineDbalPagination
 */
class ListPaginationFactory
{
    /**
     * @param Connection $dbConnection
     * @param string     $listBuilderFullClassName
     * @param array      $listParameters
     *
     * @return \Ifedko\DoctrineDbalPagination\ListPagination
     * @throws \Exception
     */
    public static function create(Connection $dbConnection, $listBuilderFullClassName, $listParameters = [])
    {
        if (!class_exists($listBuilderFullClassName)) {
            throw new ListPaginationFactoryException(sprintf('Unknown list builder class %s', $listBuilderFullClassName));
        }

        /** @var ListBuilder $listBuilder */
        $listBuilder = new $listBuilderFullClassName($dbConnection);
        $listBuilder->configure($listParameters);

        return new ListPagination($listBuilder);
    }
}
