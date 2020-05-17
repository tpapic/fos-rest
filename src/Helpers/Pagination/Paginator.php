<?php
/**
 * Created by PhpStorm.
 * User: tomislavpapic
 * Date: 15/04/2020
 * Time: 23:16
 */

namespace App\Helpers\Pagination;

use Knp\Component\Pager\PaginatorInterface as KnpPaginatorInterface;

class Paginator implements PaginatorInterface
{

    public $data;

    public $total;

    public $perPage;

    public $currentPage;

    public $lastPage;

    /**
     * @var PaginatorInterface
     */
    private $paginator;


    /**
     * Paginator constructor.
     */
    public function __construct(KnpPaginatorInterface $paginator)
    {

        $this->paginator = $paginator;
    }

    public function paginate($target, int $page = 1, int $limit = 10, array $options = [])
    {

        $paginatedData = $this->paginator->paginate($target, $page, $limit, $options);

        $this->data = $paginatedData->getItems();
        $this->total = $paginatedData->getTotalItemCount();
        $this->perPage = $paginatedData->getItemNumberPerPage();
        $this->currentPage = $paginatedData->getCurrentPageNumber();
        $this->lastPage = ceil($paginatedData->getTotalItemCount() / $paginatedData->getItemNumberPerPage());

        return $this;
    }
}