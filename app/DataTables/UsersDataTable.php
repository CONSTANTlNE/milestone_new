<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Arr;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class UsersDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->setRowId('id')
            ->editColumn('title', function ($row) {
                if (Arr::get($row->getTranslations('title'), app()->getLocale()) === null) {
                    $keys = array_keys($row->getTranslations('title'));
                    return __('strings.TranslationTitle'). ' ('. __('strings.Translated') . implode(', ', $keys). ')';
                } else {
                    return Str::limit($row->getTranslation('title', app()->getLocale()), 30);
                }
            })
            ->editColumn('role', function ($row) {
                return view('backend.partials.datatablesRoles', compact(
                    'row'
                ));
            })
            ->editColumn('images', function ($row) {
                return view('backend.partials.datatablesImages', compact(
                    'row'
                ));
            })
            ->editColumn('actions', function ($row) {
                $showGate      = 'backend.users.show';
                $editGate      = 'backend.users.edit';
                $destroyGate = '';
                if($row->roles->isEmpty() or $row->roles->first()->name != "Super Admin"){
                    $destroyGate    = 'backend.users.destroy';
                }
               $statusGate      = 'backend.pages.status';
                return view('backend.partials.datatablesActions', compact(
                    'statusGate',
                    'showGate',
                    'editGate',
                    'destroyGate',
                    'row'
                ));
            });
    }

    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->with( 'roles');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('users_table')
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
            ],
        ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id')->width(50),
            Column::make(['data' => 'title', 'title' => __('strings.Title')], 'name'),
            Column::make(['data' => 'email', 'title' => __('strings.Email')], 'email')->width(250),
            Column::computed('role', __('strings.Role')),
            Column::computed('images', __('strings.Images')),
            Column::computed('actions', __('strings.Actions'))->width(200),
        ];
    }

    protected function filename(): string
    {
        return 'Users_'.date('YmdHis');
    }
}
