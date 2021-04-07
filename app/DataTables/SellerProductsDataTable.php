<?php

namespace App\DataTables;

use App\Models\SellerProducts;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;


class SellerProductsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->toJson();
    }






    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SellerProduct $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SellerProducts $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('sellerproducts-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        // return [
        //     'id',
        //     'product_catrgory_id',
        //     'code',
        //     'name',
        //     'short_desc',
        //     'long_desc',
        //     'unit_price',
        //     'tax',
        //     'images',
        //     'discount',
        //     'colors',
        //     'sizes'
        // ];

        return [
            'id',
            'product_catrgory_id',
            'code',
            'name',
            'short_desc',
            'long_desc',
            'unit_price',
            'tax',
            'images',
            'discount',
            'colors',
            'sizes'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'SellerProducts_' . date('YmdHis');
    }
}
