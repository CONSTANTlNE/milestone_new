<?php

namespace App\DataTables;

use App\Http\Resources\PermissionResource;
use App\Models\Page;
use App\Models\Permission;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class TeamsDataTableTrash extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->editColumn('title', function ($row) {
                if (Arr::get($row->getTranslations('title'), app()->getLocale()) === null) {
                    return __('strings.TranslationPermission'). ' ('. __('strings.Translated') . implode(', ', $row->locales()). ')';
                } else {
                    return Str::limit($row->getTranslation('title', app()->getLocale()), 30);
                }
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d-m-Y h:i:s');
            })
            ->editColumn('actions', function ($row) {
                $restoreGate      = 'backend.teams.restore';
                $removeGate    = 'backend.teams.remove';

                return view('backend.partials.datatablesActionsTrash', compact(
                    'restoreGate',
                    'removeGate',
                    'row'
                ));
        });
    }

    public function query(Team $model): QueryBuilder
    {
        return $model->onlyTrashed()->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('teams_table')
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
            Column::make(['data' => 'created_at', 'title' => __('strings.Create Date')], 'created_at'),
            Column::computed('actions', __('strings.Actions'))->width(200),
        ];
    }

    protected function filename(): string
    {
        return 'TeamsTrash_'.date('YmdHis');
    }
}
