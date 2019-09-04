<?php

namespace App\Services\Paginator;

class Paginator
{
    private $recordsPerPage;
    private $currentPage;
    private $totalRecords;

    public function setRecordsPerPage(int $recordsPerPage): Paginator
    {
        $this->recordsPerPage = $recordsPerPage;
        return $this;
    }

    public function setCurrentPage(int $currentPage): Paginator
    {
        $this->currentPage = $currentPage;
        return $this;
    }

    public function setTotalRecords(int $totalRecords): Paginator
    {
        $this->totalRecords = $totalRecords;
        return $this;
    }

    public function getTotalPages(): int
    {
        return (int) ceil($this->totalRecords / $this->recordsPerPage);
    }

    public function getOffset(): int
    {
        return $this->recordsPerPage * ($this->currentPage - 1);
    }
}
