<?php

namespace App\DataTables;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SubscribersDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->setRowId('id')
            ->editColumn('actions', function ($row) {
                $destroyGate    = 'backend.subscribers.destroy';
                $showGate    = '';
                $editGate    = '';

            return view('backend.partials.datatablesActions', compact(
                'showGate',
                'editGate',
                'destroyGate',
                'row'
            ));
        });
    }

    public function query(Subscriber $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {

        return $this->builder()
        ->setTableId('subscriber_table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->orderBy(0)
        ->selectStyleSingle()
        ->responsive()
        ->parameters([
            'dom' =>  "<'row m-0'<'col-sm-3 p-0'l><'col-sm-6'B><'col-sm-3 p-0'f>>" . "<'row m-0'<'col-sm-12'tr>>" . "<'row m-0'<'col-sm-5'i><'col-sm-7'p>>",
            //'excel',
            'buttons' => ['csv'],
            'paging' => true,
            'searching' => true,
            'info' => true,
            'searchDelay' => 350,
            'language' => [
                'url' => url('/datatables/'.app()->getLocale().'.json'),
            ],
        ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id')->width(50),
            Column::make(['data' => 'email', 'title' => __('strings.Email')], 'Subscriber')->orderable(false),
            Column::computed('actions', __('strings.Actions'))->width(200),
        ];
    }

    protected function filename(): string
    {
        return 'Subscribers_'.date('YmdHis');
    }
}
