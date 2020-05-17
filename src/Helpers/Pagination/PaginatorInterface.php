<?php
/**
 * Created by PhpStorm.
 * User: tomislavpapic
 * Date: 15/04/2020
 * Time: 23:14
 */

namespace App\Helpers\Pagination;


interface PaginatorInterface
{
    public function paginate($target, int $page = 1, int $limit = 10, array $options = []);
}