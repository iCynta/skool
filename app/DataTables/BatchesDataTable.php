<?php

namespace App\DataTables;

use App\Models\Batch;
use Yajra\DataTables\Services\DataTable;

class BatchesDataTable extends DataTable
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
        //->addColumn('action', 'batches.action')
        ->addColumn('course_name', function ($batch) {
            return $batch->course ? $batch->course->name : '';
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Batch $model)
    {
        return $model->newQuery()->with('course')->select('id', 'code', 'course_id', 'name', 'created_at');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '100px'])
            ->parameters([
                'dom' => 'Bfrtip',
               'buttons' => ['excel', 'pdf', 'print'],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'code',
            'name',
            'course_name',
            'created_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Batches_' . date('YmdHis');
    }
}
