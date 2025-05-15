<?php

namespace App\DataTables;

use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class PermissionsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->setRowId('id')
            ->editColumn('title', function ($row) {
                if (Arr::get($row->getTranslations('title'), app()->getLocale()) === null) {
                    return __('strings.TranslationTitle'). ' ('. __('strings.Translated') . implode(', ', $row->locales()). ')';
                } else {
                    return Str::limit($row->getTranslation('title', app()->getLocale()), 40);
                }
            })
            ->editColumn('actions', function ($row) {
            $showGate      = 'backend.permissions.show';
            $editGate      = 'backend.permissions.edit';
            $destroyGate    = 'backend.permissions.destroy';

            return view('backend.partials.datatablesActions', compact(
                'showGate',
                'editGate',
                'destroyGate',
                'row'
            ));
        });
    }

    public function query(Permission $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('permissions_table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->orderBy(0)
        ->selectStyleSingle()
        ->responsive()
//        ->addCheckbox([
//            'class' => 'test'
//        ])
        ->parameters([
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
            Column::make(['data' => 'title', 'title' => __('strings.Title')], 'title')->orderable(false),
            Column::make(['data' => 'name', 'title' => __('strings.Route')], 'name'),
            Column::computed('actions', __('strings.Actions'))->width(200),
        ];
    }

    protected function filename(): string
    {
        return 'Permissions_'.date('YmdHis');
    }
}
