<?php

namespace App\DataTables;

use App\Models\Agencie;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AgencieDataTable extends DataTable
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
            ->addIndexColumn()
            ->editColumn('created_at', function($val) {
                return $val->created_at->format('M d\, Y');
            })
            ->addColumn('images',function ($val)
            {
                return $val->Files->count().' Images';
            })
            ->addColumn('action',function ($val)
            {
                $button = '<a href="'.route('editagencie',['agencie'=>$val->id]).'" class="btn btn-sm btn-primary">Edit</a>';
                return $button;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Agencie $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Agencie $model)
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
                    ->setTableId('agencie-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(0)
                    ->buttons(
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('phn_no'),
            Column::make('address'),
            Column::make('created_at'),
            Column::make('images'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Agencie_' . date('YmdHis');
    }
}
