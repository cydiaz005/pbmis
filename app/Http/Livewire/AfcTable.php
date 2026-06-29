<?php

namespace App\Http\Livewire;
use PowerComponents\LivewirePowerGrid\Button;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class AfcTable extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */
    public function datasource(): ?Collection
    {
        return collect(DB::table('a_f_classes')->get());
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
            ->addColumn('category')
            ->addColumn('code')
            ->addColumn('expense_object');
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
                ->title('Category')
                ->field('category')
                ->searchable()
                ->makeInputText('category')
                ->sortable(),

            Column::add()
                ->title('Code')
                ->field('code')
                ->sortable()
                ->makeInputRange('code'),

            Column::add()
                ->title('Expense Object')
                ->field('expense_object')
                ->sortable()
                ->makeInputRange('expense_object'),
     
        ];
    }

    public function actions(): array
    {
       return [
        Button::add('destroy')
        ->caption('Delete')
        ->class('bg-red-500 cursor-pointer text-red  m-1 rounded text-sm')
        ->emit('onDeleteCoaFCCItem', ['key' => 'id']),
        ];
    }
}
