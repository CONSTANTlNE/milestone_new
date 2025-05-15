<?php

namespace App\DataTables;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Arr;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class RolesDataTableTrash extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->editColumn('title', function ($row) {
                if (Arr::get($row->getTranslations('title'), app()->getLocale()) === null) {
                    return __('strings.TranslationTitle'). ' ('. __('strings.Translated') . implode(', ', $row->locales()). ')';
                } else {
                    return Str::limit($row->getTranslation('title', app()->getLocale()), 30);
                }
            })
            ->editColumn('actions', function ($row) {
                $restoreGate      = 'backend.roles.restore';
                $removeGate    = 'backend.roles.remove';

                return view('backend.partials.datatablesActionsTrash', compact(
                    'restoreGate',
                    'removeGate',
                    'row'
                ));
            });
    }

    public function query(Role $model): QueryBuilder
    {
        return $model->onlyTrashed()->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('roles_table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0)
            ->selectStyleSingle()
            ->responsive()
            ->parameters([
                'paging' => true,
                'searching' => true,
                'info' => true,
                'searchDelay' => 350,
                'language' => [
                    'url' => url('/datatables/'.app()->getLocale().'.json'),
                ]
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id')->width(50),
            Column::make(['data' => 'title', 'title' => __('strings.Title')], 'title')->orderable(false),
            Column::make(['data' => 'name', 'title' => __('strings.Code')], 'name'),
            Column::computed('actions', __('strings.Actions'))->width(200),
        ];
    }

    protected function filename(): string
    {
        return 'rolesTrash_'.date('YmdHis');
    }
}
