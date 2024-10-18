<?php

namespace App\DataTables;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;
use Carbon\Carbon;


class TasksDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query->select('tasks.*')))
            ->addIndexColumn()

            ->editColumn('due_date', function ($record) {
                return $record->due_date->format(config('constant.date_format.date'));
            })

            ->editColumn('title', function ($record) {
                return $record->title ? ucwords($record->title) : '';
            })

            ->editColumn('description', function ($record) {
                return $record->description ?? '';
            })

            ->editColumn('status', function ($record) {
                $checkedStatus = '';
                if ($record->status == 'completed') {
                    $checkedStatus = 'checked';
                }
                return '<div class="checkbox switch">
                    <label>
                        <input type="checkbox" class="switch-control task_status_cb" ' . $checkedStatus . ' data-task_id="' . ($record->uuid) . '" />
                        <span class="switch-label"></span>
                    </label>
                </div>';
            })

            ->addColumn('action', function ($record) {
                $actionHtml = '';
                $actionHtml .= '<a href="' . route('tasks.edit', $record->uuid) . '" class="btn btn-outline-primary btn-sm btnEdittask" id="btnEdittask" title="Edit"> <i class="ri-pencil-line"></i> </a>';
        
                $actionHtml .= '<a href="javascript:void(0);" class="btn btn-outline-danger btn-sm deletetaskBtn" data-href="' . route('tasks.destroy', $record->uuid) . '" title="Delete"><i class="ri-delete-bin-line"></i></a>';
                return $actionHtml;
            })
            ->setRowId('id')

            ->filterColumn('created_at', function ($query, $keyword) {
                $date_range = explode(' - ', $keyword);
                $startDate = Carbon::parse($date_range[0]);
                $endDate   = Carbon::parse($date_range[1]);

                $query->whereBetween('tasks.created_at', [$startDate->startOfDay(), $endDate->endOfDay()]);
            })
            ->filterColumn('status', function ($query, $keyword) {
                $statusSearch  = null;
                if (Str::contains('completed', strtolower($keyword))) {
                    $statusSearch = 'completed';
                } else if (Str::contains('pending', strtolower($keyword))) {
                    $statusSearch = 'pending';
                }
                $query->where('status', $statusSearch);
            })
            ->rawColumns(['action', 'status']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Task $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('tasks-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::computed('action')->exportable(false)->printable(false)->width(60)->addClass('text-center'),
            Column::make('title')->title('Title'),
            Column::make('description')->title('Description'),
            Column::make('status')->title('Status'),
            Column::make('due_date')->title('Due Date'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Tasks_' . date('YmdHis');
    }
}
