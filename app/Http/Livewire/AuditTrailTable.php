<?php

namespace App\Http\Livewire;

use App\Models\User;
use PowerComponents\LivewirePowerGrid\Button;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use Illuminate\Support\Facades\DB;
use Spatie\Backup\Helpers\ConsoleOutput;

final class AuditTrailTable extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */
    public function datasource(): ? EloquentBuilder
    {
        return Activity::with(['causer']);
        //convert activity logs to array
        // $activity_logs = json_decode(json_encode(Activity::with(['causer'])->get()));
        // // $activity_logs = [];
        // //map activity logs array and mutate fields
        // array_map(function ($item) {
        //     return mutateItemFields($item);
        // }, $activity_logs);

        // return collect(
        //     $activity_logs
        // );
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */
    public function setUp(): void
    {
        $this->showCheckBox()
            ->showPerPage()
            ->showExportOption('download', ['excel', 'csv'])
            ->showSearchInput();
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('description')
            ->addColumn('causer', function ($model) {
                if (isset($model->causer)) {
                    return $model->causer->firstname . ' ' . $model->causer->lastname;
                } else {
                    return "System";
                }
            })
            // ->addColumn('properties')
            ->addColumn('created_at_formatted', function ($entry) {
                return Carbon::parse($entry->created_at)->format('d/m/Y H:i:s');
            });
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |

    */
    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::add()
                ->title('ID')
                ->field('id')
                ->searchable()
                ->sortable(),
            Column::add()
                ->title('Causer')
                ->field('causer')
                ->searchable()
                ->sortable(),

            Column::add()
                ->title('Description')
                ->field('description')
                ->searchable()
                ->makeInputText('description')
                ->sortable(),

            // Column::add()
            //     ->title('Properties')
            //     ->field('properties')
            //     ->searchable()
            //     ->makeInputText('properties')
            //     ->sortable(),

            // Column::add()
            //     ->title('Price')
            //     ->field('price')
            //     ->sortable()
            //     ->makeInputRange('price', '.', ''),

            Column::add()
                ->title('Created At')
                ->field('created_at_formatted')
                ->makeInputDatePicker('created_at'),

        ];
    }

    public function actions(): array
    {

        return [
            Button::add('view')
                ->caption('View Details')
                ->class('bg-indigo-500 cursor-pointer text-white  py-1 px-2 m-1 rounded text-sm')
                ->emit('onOpenViewModal', ['key' => 'id', 'properties' => 'properties']),
        ];
    }
}
