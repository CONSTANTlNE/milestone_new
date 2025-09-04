<?php

namespace App\DataTables;

use App\Models\CarrierDispatcher;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CarrierDispatcherDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($carrierDispatcher) {
                return view('backend.carrier_dispatchers.actions', compact('carrierDispatcher'));
            })
            ->addColumn('status_badge', function($carrierDispatcher) {
                return $carrierDispatcher->status_badge;
            })
            ->addColumn('payment_method_text', function($carrierDispatcher) {
                return $carrierDispatcher->payment_method_text;
            })
            ->addColumn('created_at', function($carrierDispatcher) {
                return $carrierDispatcher->created_at->format('M d, Y H:i');
            })
            ->rawColumns(['action', 'status_badge'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(CarrierDispatcher $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('carrier-dispatcher-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1, 'desc')
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('ID'),
            Column::make('legal_business_name')->title('Business Name'),
            Column::make('contact_name')->title('Contact Name'),
            Column::make('contact_email')->title('Email'),
            Column::make('mc_number')->title('MC Number'),
            Column::make('dot_number')->title('DOT Number'),
            Column::make('cars_under_management')->title('Cars Managed'),
            Column::make('payment_method_text')->title('Payment Method'),
            Column::make('status_badge')->title('Status'),
            Column::make('created_at')->title('Submitted'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(120)
                  ->addClass('text-center')
                  ->title('Actions'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'CarrierDispatchers_' . date('YmdHis');
    }
}
