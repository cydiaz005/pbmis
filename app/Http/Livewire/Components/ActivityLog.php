<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Component
{
    //array of log_name in activity_log table; passed from blade views
    public $log_names;

    //can be override by passing from $field and $sort_type this component
    public $field = "id", $sort_type = "desc";

    //initialize activity logs
    protected $activity_logs;

    public function mutatePropertiesField($activity_logs)
    {
        $logs = json_decode(json_encode($activity_logs));

        //map activity logs array and mutate fields
        array_map(function ($item) {
            return mutateItemFields($item);
        }, $logs);

        return $logs;
    }

    //function to get all activity_logs
    public function getActivityLogs()
    {
        if (!$this->log_names) {
            $activity_logs = Activity::orderBy($this->field, $this->sort_type)
                ->with(["causer"])
                ->limit(5)
                ->get();
        } else {
            $activity_logs = Activity::where("log_name", $this->log_names)
                ->with(["causer"])
                ->orderBy($this->field, $this->sort_type)
                ->limit(5)
                ->get();
        }

        $this->activity_logs = $this->mutatePropertiesField($activity_logs);
    }

    public function openActivityLogViewModal($item)
    {
        $this->dispatchBrowserEvent('openActivityLogViewModal', $item);
    }

    //return the view and pass necessary vars from this
    public function render()
    {
        //get all the activity logs
        $this->getActivityLogs();
        $data = [
            "activity_logs" => $this->activity_logs
        ];

        return view('livewire.components.activity-log', $data);
    }
}
